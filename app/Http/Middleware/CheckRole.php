<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        if(!auth()->check()){
            return response()->json(['error' => 'Ошибка авторизации','code'=>401], 401);
        }
        /** @var User $user_id */
        $user_id = auth()->user()->role_id;
        if (!in_array($user_id, $roles)) {
            return response()->json(['error' => 'Недоступно для Вас','code'=>401], 401);
        }
        return $next($request);
    }
}
