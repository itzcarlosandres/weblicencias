<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with(['category', 'brand']);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($category = $request->input('category')) {
            $cat = Category::where('slug', $category)->first();
            if ($cat) {
                $query->where('category_id', $cat->id);
            }
        }

        // Brand filter
        if ($brand = $request->input('brand')) {
            $brandModel = Brand::where('slug', $brand)->first();
            if ($brandModel) {
                $query->where('brand_id', $brandModel->id);
            }
        }

        // Price range
        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', $maxPrice);
        }

        // Type filter
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Sorting
        $sortBy = $request->input('sort', 'featured');
        $query = match($sortBy) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name', 'asc'),
            'newest' => $query->latest(),
            'best_selling' => $query->orderBy('sold_count', 'desc'),
            default => $query->orderBy('is_featured', 'desc')->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('order')
            ->get();

        $brands = Brand::where('is_active', true)->get();

        $gridColumns = (int) Setting::get('catalog_grid_columns', 3);
        $gridColumns = max(2, min(6, $gridColumns));
        $gridClass = $this->getGridClass($gridColumns);

        return view('pages.products.index', compact(
            'products', 'categories', 'brands', 'gridColumns', 'gridClass'
        ));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'brand', 'reviews.user'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        if ($relatedProducts->count() < 6) {
            $moreProducts = Product::where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->where('is_active', true)
                ->inRandomOrder()
                ->limit(6 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($moreProducts);
        }

        $pointsService = app(\App\Services\PointsService::class);
        $pointsEarned = $pointsService->calculatePointsForOrder($product->discounted_price);

        return view('pages.products.show', compact('product', 'relatedProducts', 'pointsEarned'));
    }

    public function liveSearch(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'name', 'slug', 'image', 'price', 'compare_price', 'discount'])
            ->map(function ($product) {
                $product->url = route('products.show', $product->slug);
                $product->image_url = $product->image ? asset('storage/' . $product->image) : asset('img/no-image.png');
                $product->formatted_price = str_replace('$', '', $product->formatted_discounted_price);
                if ($product->has_discount) {
                    $product->formatted_compare = str_replace('$', '', $product->formatted_compare_price);
                }
                return $product;
            });

        return response()->json($products);
    }

    public function flashSales(Request $request)
    {
        $products = Product::where('is_active', true)
            ->where('is_flash_sale', true)
            ->whereNotNull('flash_sale_end')
            ->where('flash_sale_end', '>', now())
            ->with(['category', 'brand'])
            ->orderBy('flash_sale_end', 'asc')
            ->paginate(12);

        return view('pages.products.flash_sales', compact('products'));
    }

    private function getGridClass(int $cols): string
    {
        $mobile = match (true) {
            $cols <= 2 => 'grid-cols-1',
            $cols <= 4 => 'grid-cols-2',
            default => 'grid-cols-2',
        };
        $tablet = match (true) {
            $cols <= 2 => 'sm:grid-cols-2',
            $cols <= 3 => 'sm:grid-cols-2',
            $cols <= 4 => 'sm:grid-cols-2',
            default => 'sm:grid-cols-3',
        };
        $desktop = match ($cols) {
            2 => 'lg:grid-cols-2',
            3 => 'lg:grid-cols-3',
            4 => 'lg:grid-cols-4',
            5 => 'lg:grid-cols-5',
            6 => 'lg:grid-cols-6',
            default => 'lg:grid-cols-3',
        };
        return "{$mobile} {$tablet} {$desktop}";
    }
}
