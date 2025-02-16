<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $resourceOwnerId = $request->route('id'); // Lấy ID từ URL
        if ($user && $user->id == $resourceOwnerId) {
            return $next($request);
        }
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}