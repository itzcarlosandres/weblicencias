<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Services\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    protected LicenseService $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            $query->where('category_id', $category);
        }

        $products = $query->latest()->paginate(20)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $badges = \App\Models\Badge::where('is_active', true)->orderBy('name')->get();
        $regions = \App\Models\ProductAttribute::where('type', 'region')->orderBy('value')->get();
        $activationMethods = \App\Models\ProductAttribute::where('type', 'activation_method')->orderBy('value')->get();
        $platforms = \App\Models\ProductAttribute::where('type', 'platform')->orderBy('value')->get();

        return view('admin.products.create', compact('categories', 'brands', 'badges', 'regions', 'activationMethods', 'platforms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'type' => 'required|in:license,software,giftcard,subscription',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'is_top_deal' => 'boolean',
            'is_flash_sale' => 'boolean',
            'flash_sale_end' => 'nullable|date',
            'is_active' => 'boolean',
            'platform' => 'nullable|string',
            'region' => 'nullable|string',
            'activation_method' => 'nullable|string',
            'delivery_time' => 'nullable|string',
            'warranty_days' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_bundle' => 'boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'badge_id' => 'nullable|exists:badges,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['sku'] = strtoupper(substr(uniqid(), -8));

        if (!isset($validated['is_featured'])) $validated['is_featured'] = false;
        if (!isset($validated['is_top_deal'])) $validated['is_top_deal'] = false;
        if (!isset($validated['is_flash_sale'])) $validated['is_flash_sale'] = false;
        if (!isset($validated['is_bundle'])) $validated['is_bundle'] = false;
        if (!isset($validated['is_active'])) $validated['is_active'] = true;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Producto creado correctamente');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $badges = \App\Models\Badge::where('is_active', true)->orderBy('name')->get();
        $regions = \App\Models\ProductAttribute::where('type', 'region')->orderBy('value')->get();
        $activationMethods = \App\Models\ProductAttribute::where('type', 'activation_method')->orderBy('value')->get();
        $platforms = \App\Models\ProductAttribute::where('type', 'platform')->orderBy('value')->get();
        $licenseStats = $this->licenseService->getLicensesStats($product);

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'badges', 'regions', 'activationMethods', 'platforms', 'licenseStats'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'type' => 'required|in:license,software,giftcard,subscription',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'is_top_deal' => 'boolean',
            'is_flash_sale' => 'boolean',
            'flash_sale_end' => 'nullable|date',
            'is_active' => 'boolean',
            'platform' => 'nullable|string',
            'region' => 'nullable|string',
            'activation_method' => 'nullable|string',
            'delivery_time' => 'nullable|string',
            'warranty_days' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_bundle' => 'boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'badge_id' => 'nullable|exists:badges,id',
        ]);

        if (!isset($validated['is_featured'])) $validated['is_featured'] = false;
        if (!isset($validated['is_top_deal'])) $validated['is_top_deal'] = false;
        if (!isset($validated['is_flash_sale'])) $validated['is_flash_sale'] = false;
        if (!isset($validated['is_bundle'])) $validated['is_bundle'] = false;
        if (!isset($validated['is_active'])) $validated['is_active'] = false;

        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $oldPrice = $product->discounted_price;

        $product->update($validated);

        $newPrice = $product->discounted_price;

        if ($newPrice < $oldPrice) {
            $usersToNotify = \App\Models\Wishlist::where('product_id', $product->id)->with('user')->get()->pluck('user');
            foreach ($usersToNotify as $user) {
                \Illuminate\Support\Facades\Mail::to($user->email)->queue(new \App\Mail\WishlistPriceDropMail($product, $oldPrice, $newPrice));
            }
        }

        return back()->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado correctamente');
    }

    public function importLicenses(Request $request, Product $product)
    {
        $request->validate([
            'licenses' => 'required|string',
        ]);

        $keys = explode("\n", $request->licenses);
        $imported = $this->licenseService->importLicenses($product, $keys);

        // Notify waitlisted users
        if ($imported > 0) {
            $waitlist = \App\Models\Waitlist::where('product_id', $product->id)->get();
            foreach ($waitlist as $entry) {
                \Illuminate\Support\Facades\Mail::to($entry->email)->queue(new \App\Mail\ProductInStockMail($product));
                $entry->delete(); // Remove from waitlist
            }
        }

        return back()->with('success', "{$imported} licencias importadas correctamente y lista de espera notificada");
    }

    public function toggleFeatured(Product $product)
    {
        $product->update([
            'is_featured' => !$product->is_featured
        ]);

        return back()->with('success', 'Estado destacado actualizado');
    }

    public function toggleBundle(Product $product)
    {
        $product->update([
            'is_bundle' => !$product->is_bundle
        ]);

        return back()->with('success', 'Estado de paquete actualizado');
    }

    public function toggleBestSeller(Product $product)
    {
        $product->update([
            'is_bestseller' => !$product->is_bestseller
        ]);

        return back()->with('success', 'Estado de más vendido actualizado');
    }

    public function toggleTopDeal(Product $product)
    {
        $product->update([
            'is_top_deal' => !$product->is_top_deal
        ]);

        return back()->with('success', 'Estado de Top Oferta actualizado');
    }
}
