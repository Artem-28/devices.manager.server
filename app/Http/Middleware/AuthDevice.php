<?php

namespace App\Http\Middleware;

use App\Services\ControlDeviceService;
use App\Traits\Permission;
use Closure;
use Illuminate\Http\Request;

class AuthDevice
{
    use Permission;
    private ControlDeviceService $controlDeviceService;

    public function __construct(ControlDeviceService $controlDeviceService)
    {
        $this->controlDeviceService = $controlDeviceService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next): \Illuminate\Http\JsonResponse
    {
        $device = auth()->user();
        if ($device && $this->checkPermissionControlDevice($device)) {
            $response = $next($request);
            $device->tokens()->delete();
            $token = $this->controlDeviceService->createToken($device);
            $response->header('Access-Token', $token);
            return $response;
        }

        return response()->json([
            'success'=> false,
            'message' => 'device not authorized'
        ], 401);
    }
}
