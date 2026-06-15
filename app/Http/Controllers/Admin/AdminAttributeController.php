<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;

class AdminAttributeController extends Controller
{
    public function index()
    {
        $regions = ProductAttribute::where('type', 'region')->orderBy('value')->get();
        $activationMethods = ProductAttribute::where('type', 'activation_method')->orderBy('value')->get();
        $platforms = ProductAttribute::where('type', 'platform')->orderBy('value')->get();

        return view('admin.attributes.index', compact('regions', 'activationMethods', 'platforms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:region,activation_method,platform',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'type' => $request->type,
            'value' => $request->value,
            'icon' => $request->icon,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('attributes', 'public');
        }

        ProductAttribute::create($data);

        return redirect()->route('admin.attributes.index')->with('success', 'Atributo agregado correctamente.');
    }

    public function destroy(ProductAttribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('admin.attributes.index')->with('success', 'Atributo eliminado correctamente.');
    }
}
