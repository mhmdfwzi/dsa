<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class IsTrainer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            
            if ($user->isTrainer()) {
                return $next($request);
            }
        }

        abort(403, 'ليس لديك صلاحية الوصول كمدرب');
    }
}