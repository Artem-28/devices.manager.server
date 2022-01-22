<?php

namespace App\Http\Middleware;

use App\Services\ControlDeviceService;
use Closure;
use Illuminate\Http\Request;

class AuthDevice
{
    private $controlDeviceService;

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
    public function handle(Request $request, Closure $next)
    {
        $serialNumber = $request->header('serial-number');
        $accessToken = $request->header('access-token');
        $controlDevice = $this->controlDeviceService->getAuthDevice($serialNumber, $accessToken);
        if ($controlDevice) {
            $request['controlDevice'] = $controlDevice;
            return $next($request);
        }
        return response()->json([
            'success'=> false,
            'message' => 'device not authorized'
        ], 401);
    }
}
