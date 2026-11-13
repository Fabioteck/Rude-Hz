<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePlan
{
    public function handle(Request $request, Closure $next, string $requiredPlan = 'pro'): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $hierarchy = config('plans.hierarchy', ['free' => 0, 'supporter' => 1, 'pro' => 2]);
        
        $userPlan = $user->plan ?? 'free';
        $userLevel = $hierarchy[$userPlan] ?? 0;
        $requiredLevel = $hierarchy[$requiredPlan] ?? 2;

        if ($userLevel < $requiredLevel) {
            abort(403, 'Unauthorized plan access.');
        }

        return $next($request);
    }
}
