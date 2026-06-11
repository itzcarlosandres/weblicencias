<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();
        $discount = $this->cartService->getDiscount();
        $tax = $this->cartService->getTax();
        $total = $this->cartService->getTotal();
        $couponCode = $this->cartService->getCouponCode();

        return view('pages.cart', compact('cart', 'subtotal', 'discount', 'tax', 'total', 'couponCode'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $this->cartService->addItem($product, $request->quantity ?? 1);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'count' => $this->cartService->getCount(),
                'message' => 'Producto agregado al carrito'
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito');
    }

    public function addBundle(Request $request)
    {
        $product1 = Product::findOrFail($request->product_id_1);
        $product2 = Product::findOrFail($request->product_id_2);

        // Calculate 15% discount for both
        $this->cartService->addDiscountedItem($product1, 1, 15);
        $this->cartService->addDiscountedItem($product2, 1, 15);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'count' => $this->cartService->getCount(),
                'message' => 'Paquete agregado al carrito con 15% de descuento'
            ]);
        }

        return back()->with('success', 'Paquete agregado al carrito');
    }

    public function update(Request $request)
    {
        $this->cartService->updateQuantity($request->product_id, $request->quantity);

        return response()->json([
            'success' => true,
            'count' => $this->cartService->getCount(),
            'subtotal' => $this->cartService->getSubtotal(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    public function remove(Request $request)
    {
        $this->cartService->removeItem($request->product_id);

        return response()->json([
            'success' => true,
            'count' => $this->cartService->getCount(),
            'subtotal' => $this->cartService->getSubtotal(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $result = $this->cartService->applyCoupon($request->code);

        return response()->json($result);
    }

    public function removeCoupon()
    {
        $this->cartService->removeCoupon();

        return response()->json([
            'success' => true,
            'discount' => 0,
            'total' => $this->cartService->getTotal(),
        ]);
    }
}
