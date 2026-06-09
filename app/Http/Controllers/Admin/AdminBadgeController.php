<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;

class AdminBadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::latest()->get();
        return view('admin.badges.index', compact('badges'));
    }

    public function create()
    {
        return view('admin.badges.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'color' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        if (!isset($validated['is_active'])) $validated['is_active'] = false;

        Badge::create($validated);

        return redirect()->route('admin.badges.index')->with('success', 'Etiqueta creada exitosamente.');
    }

    public function edit(Badge $badge)
    {
        return view('admin.badges.edit', compact('badge'));
    }

    public function update(Request $request, Badge $badge)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'color' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        if (!isset($validated['is_active'])) $validated['is_active'] = false;

        $badge->update($validated);

        return redirect()->route('admin.badges.index')->with('success', 'Etiqueta actualizada exitosamente.');
    }

    public function destroy(Badge $badge)
    {
        $badge->delete();
        return back()->with('success', 'Etiqueta eliminada exitosamente.');
    }
}
