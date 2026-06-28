<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function sitemap()
    {
        $products = Product::active()->get();
        $categories = Category::active()->get();
        $blogs = BlogPost::published()->get();

        return response()->view('seo.sitemap', compact('products', 'categories', 'blogs'))
                         ->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $content  = "User-agent: *\n";

        // Rutas privadas / de administración
        $content .= "Disallow: /admin/\n";

        // Rutas de cuenta de cliente (rutas en español)
        $content .= "Disallow: /mi-cuenta/\n";

        // Autenticación
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Disallow: /forgot-password\n";
        $content .= "Disallow: /reset-password\n";

        // Proceso de compra
        $content .= "Disallow: /carrito\n";
        $content .= "Disallow: /checkout\n";

        // Pasarelas de pago
        $content .= "Disallow: /paypal/\n";
        $content .= "Disallow: /mercadopago/\n";
        $content .= "Disallow: /wompi/\n";
        $content .= "Disallow: /webhook/\n";

        // Rutas de API internas
        $content .= "Disallow: /api/\n";
        $content .= "Disallow: /search/live\n";

        // Moneda (no tiene valor SEO)
        $content .= "Disallow: /currency/\n\n";

        // Todo lo demás es permitido
        $content .= "Allow: /\n\n";

        // Sitemap
        $content .= "Sitemap: " . url('sitemap.xml') . "\n";

        return response($content, 200)
                ->header('Content-Type', 'text/plain');
    }
}

