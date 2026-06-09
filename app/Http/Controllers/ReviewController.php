<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'image' => 'nullable|image|max:2048', // max 2MB
        ]);

        // Check if user already reviewed
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Ya has enviado una reseña para este producto.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        // Check if user actually purchased this product
        $hasPurchased = \App\Models\Order::where('user_id', Auth::id())
            ->whereIn('status', ['paid', 'delivered'])
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->exists();

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'image' => $imagePath,
            'is_verified' => $hasPurchased,
            'is_approved' => true, 
        ]);

        return back()->with('success', '¡Gracias por tu reseña! Ha sido publicada con éxito.');
    }
}
