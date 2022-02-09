<?php

namespace App\Http\Middleware;

use App\Traits\Permission;
use Closure;
use Illuminate\Http\Request;

class AuthUser
{
    use Permission;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if ($this->checkPermissionUser($user)) {
            return $next($request);
        }

        return response()->json([
            'success'=> false,
            'message' => 'user not authorized'
        ], 401);
    }
}
