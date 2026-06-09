<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminReferralController extends Controller
{
    public function index()
    {
        $referrers = User::whereHas('referredUsers')
            ->withCount('referredUsers')
            ->orderByDesc('referred_users_count')
            ->paginate(20);

        return view('admin.referrals.index', compact('referrers'));
    }
}
