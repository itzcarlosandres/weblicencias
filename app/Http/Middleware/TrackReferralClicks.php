<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class TrackReferralClicks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('ref')) {
            $refCode = $request->get('ref');
            
            // To prevent spam, check if we already tracked a click in this session
            if (!session()->has('referral_click_tracked')) {
                $user = User::where('referral_code', $refCode)->first();
                if ($user) {
                    $user->increment('referral_clicks');
                    session(['referral_click_tracked' => true]);
                }
            }
            
            // Store the code for registration
            session(['referral_code' => $refCode]);
        }
        
        return $next($request);
    }
}
