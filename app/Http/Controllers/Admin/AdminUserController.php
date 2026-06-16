<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PointsService;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected PointsService $pointsService;

    public function __construct(PointsService $pointsService)
    {
        $this->pointsService = $pointsService;
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders.items', 'pointTransactions' => function($q) {
            $q->latest()->take(10);
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function addPoints(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|integer|min:-100000|max:100000|not_in:0',
            'description' => 'required|string|max:255',
        ]);

        $amount = (int) $request->input('amount');
        $description = $request->input('description');

        if ($amount > 0) {
            $this->pointsService->awardPoints($user, $amount, $description);
            $message = "Se han añadido {$amount} TodoPuntos al usuario correctamente.";
        } else {
            // Deduct points
            $amountToDeduct = abs($amount);
            if ($user->points < $amountToDeduct) {
                return back()->with('error', 'El usuario no tiene suficientes puntos para deducir esa cantidad.');
            }
            $this->pointsService->redeemPoints($user, $amountToDeduct, $description);
            $message = "Se han restado {$amountToDeduct} TodoPuntos al usuario correctamente.";
        }

        return back()->with('success', $message);
    }

    public function adjustWallet(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|not_in:0',
            'description' => 'required|string|max:255',
        ]);

        $amount = (float) $request->input('amount');
        $description = $request->input('description');

        if ($amount < 0 && $user->wallet_balance < abs($amount)) {
            return back()->with('error', 'El usuario no tiene suficiente saldo en el monedero para deducir esa cantidad.');
        }

        $user->wallet_balance += $amount;
        $user->save();

        \App\Models\WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'admin_adjustment',
            'amount' => $amount,
            'description' => $description,
        ]);

        $message = $amount > 0 
            ? "Se han añadido $" . number_format($amount, 2) . " al monedero del usuario."
            : "Se han restado $" . number_format(abs($amount), 2) . " del monedero del usuario.";

        return back()->with('success', $message);
    }
}
