<?php

namespace App\Http\Controllers\ApiDevice;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LiveCheckController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:sanctum', 'auth.device']);
    }

    public function check(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $controlDevice = auth()->user();
            $data = Carbon::now();
            $controlDevice->last_contact = $data;
            $controlDevice->save();
        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true
        ]);
    }
}
