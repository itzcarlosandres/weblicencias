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
        $content = "User-agent: *\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /customer/\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Disallow: /cart\n";
        $content .= "Disallow: /checkout\n\n";
        $content .= "Allow: /\n\n";
        $content .= "Sitemap: " . url('sitemap.xml') . "\n";

        return response($content, 200)
                ->header('Content-Type', 'text/plain');
    }
}
