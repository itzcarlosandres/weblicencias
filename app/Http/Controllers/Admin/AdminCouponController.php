<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::query();
        if ($search = $request->input('search')) {
            $query->where('code', 'like', "%{$search}%");
        }
        $coupons = $query->latest()->paginate(20)->withQueryString();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);
        if (!isset($validated['is_active'])) $validated['is_active'] = true;
        $validated['code'] = strtoupper($validated['code']);
        $validated['used_count'] = 0;
        $coupon = Coupon::create($validated);
        return redirect()->route('admin.coupons.edit', $coupon)->with('success', 'Cupón creado correctamente');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);
        if (!isset($validated['is_active'])) $validated['is_active'] = false;
        $validated['code'] = strtoupper($validated['code']);
        $coupon->update($validated);
        return back()->with('success', 'Cupón actualizado correctamente');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Cupón eliminado correctamente');
    }
}
