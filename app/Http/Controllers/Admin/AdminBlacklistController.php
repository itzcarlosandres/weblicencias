<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminBlacklistController extends Controller
{
    public function index()
    {
        $blacklists = Blacklist::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.blacklist.index', compact('blacklists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:ip,country',
            'value' => 'required|string|max:255',
            'reason' => 'nullable|string|max:255',
        ]);

        Blacklist::create($request->only(['type', 'value', 'reason']));
        Cache::forget('blacklisted_ips');

        return redirect()->route('admin.blacklist.index')->with('success', 'Añadido a la lista negra.');
    }

    public function destroy(Blacklist $blacklist)
    {
        $blacklist->delete();
        Cache::forget('blacklisted_ips');

        return redirect()->route('admin.blacklist.index')->with('success', 'Eliminado de la lista negra.');
    }
}
