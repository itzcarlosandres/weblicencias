<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query();
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $brands = $query->latest()->paginate(20)->withQueryString();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'show_on_home' => 'boolean',
            'logo' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:255',
        ]);
        if (!isset($validated['is_active'])) $validated['is_active'] = true;
        if (!isset($validated['show_on_home'])) $validated['show_on_home'] = true;
        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $brand = Brand::create($validated);
        return redirect()->route('admin.brands.edit', $brand)->with('success', 'Marca creada correctamente');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'show_on_home' => 'boolean',
            'logo' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:255',
        ]);
        if (!isset($validated['is_active'])) $validated['is_active'] = false;
        if (!isset($validated['show_on_home'])) $validated['show_on_home'] = false;
        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $brand->update($validated);
        return back()->with('success', 'Marca actualizada correctamente');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Marca eliminada correctamente');
    }
}
