<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;
use App\Models\Setting;
use Livewire\Livewire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCount = (int) Setting::get('home_featured_count', 8);
        $gridColumns = (int) Setting::get('home_grid_columns', 4);
        $gridColumns = max(2, min(6, $gridColumns));

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with(['category', 'badge'])
            ->latest()
            ->limit($featuredCount)
            ->get();

        $latestProducts = Product::where('is_active', true)
            ->with(['category', 'badge'])
            ->latest()
            ->limit($featuredCount)
            ->get();

        $bundleProducts = Product::where('is_active', true)
            ->where('is_bundle', true)
            ->with(['category', 'badge'])
            ->latest()
            ->limit(3)
            ->get();

        $bestsellerProducts = Product::where('is_active', true)
            ->where('is_bestseller', true)
            ->with(['category', 'badge'])
            ->latest()
            ->limit(10)
            ->get();

        $topDeals = Product::topDeals()->active()->with(['category', 'badge'])->latest()->limit(12)->get();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount(['products as products_count' => function ($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('order')
            ->limit(10)
            ->get();

        $latestPosts = BlogPost::published()
            ->with('author')
            ->latest('published_at')
            ->limit(3)
            ->get();

        $stats = \Illuminate\Support\Facades\Cache::remember('home_stats', 1800, function() {
            return [
                'licenses_sold' => Product::sum('sold_count'),
                'total_users' => \App\Models\User::count(),
                'total_products' => Product::where('is_active', true)->count(),
                'total_orders' => \App\Models\Order::where('status', 'delivered')->count(),
            ];
        });

        $brandsArray = \Illuminate\Support\Facades\Cache::rememberForever('active_brands', function() {
            return \App\Models\Brand::active()->orderBy('name')->get()->toArray();
        });
        $brands = \App\Models\Brand::hydrate($brandsArray);

        $gridClass = $this->getGridClass($gridColumns);

        return view('pages.home', compact(
            'featuredProducts',
            'latestProducts',
            'bundleProducts',
            'bestsellerProducts',
            'topDeals',
            'categories',
            'latestPosts',
            'stats',
            'brands',
            'gridColumns',
            'gridClass'
        ));
    }

    public function demos()
    {
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with(['category', 'badge'])
            ->limit(10)
            ->get();

        return view('pages.demos', compact('featuredProducts'));
    }

    public function changeCurrency(string $currency)
    {
        if (in_array(strtoupper($currency), ['USD', 'COP', 'MXN', 'EUR'])) {
            session(['currency' => strtoupper($currency)]);
        }
        return back();
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
            default => 'lg:grid-cols-4',
        };
        return "{$mobile} {$tablet} {$desktop}";
    }

    public function socialProof()
    {
        // Obtener una orden reciente real, o simular una con productos populares
        $recentOrders = \App\Models\OrderItem::with('product')
            ->latest()
            ->take(20)
            ->get();

        if ($recentOrders->count() > 0) {
            $recentOrder = $recentOrders->random();
            if ($recentOrder && $recentOrder->product) {
                $names = ['Carlos', 'María', 'David', 'Ana', 'Jorge', 'Laura', 'Pedro', 'Sofía'];
                $countries = ['Colombia', 'México', 'España', 'Argentina', 'Chile', 'Perú'];
                
                return response()->json([
                    'success' => true,
                    'name' => $names[array_rand($names)],
                    'country' => $countries[array_rand($countries)],
                    'product_name' => $recentOrder->product->name,
                    'product_image' => $recentOrder->product->image ? asset('storage/' . $recentOrder->product->image) : null,
                    'product_url' => route('products.show', $recentOrder->product->slug),
                    'time_ago' => rand(1, 45) . ' min',
                ]);
            }
        }

        return response()->json(['success' => false]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSend(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'subject.required' => 'El asunto es obligatorio.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres.',
        ]);

        $contactEmail = Setting::get('contact_email', 'soporte@todokeys.co');

        try {
            Mail::to($contactEmail)->send(new ContactMessageMail(
                $request->input('name'),
                $request->input('email'),
                $request->input('subject'),
                $request->input('message')
            ));
        } catch (\Exception $e) {
            \Log::error('Error al enviar correo de contacto: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Lo sentimos, hubo un problema al enviar tu mensaje. Por favor intenta de nuevo.');
        }

        return back()->with('success', '¡Gracias por contactarnos! Hemos recibido tu mensaje y te responderemos lo antes posible.');
    }

    public function helpCenter()
    {
        return view('pages.help-center');
    }
}

