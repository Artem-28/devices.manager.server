<?php

namespace App\Http\Controllers\ApiDevice;

use App\Http\Controllers\Controller;
use App\Services\ControlDeviceService;
use App\Services\UserService;
use App\Traits\DataPreparation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControlDeviceController extends Controller
{
    use DataPreparation;
    private UserService $userService;
    private ControlDeviceService $controlDeviceService;

    public function __construct
    (
        UserService $userService,
        ControlDeviceService $controlDeviceService
    )
    {

        $this->userService = $userService;
        $this->controlDeviceService = $controlDeviceService;
    }

    // Регистрация нового устройства
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $userData = $request->only('email', 'password',);
            $deviceData = $request->only( 'serial_number', 'title');

            $user = $this->userService->getUserByLogin($userData['email']);
            if (!$user || ! Auth::attempt($userData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Неверный логин или пароль'
                ], 401);
            }
            $deviceData['account_id'] = $user->account_id;
            $this->controlDeviceService->createDevice($deviceData);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    // Получение токена для авторизации устройства
    public function getToken(Request $request): \Illuminate\Http\JsonResponse
    {
        $login = $request->get('email');
        $serialNumber = $request->get('serial_number');
        $user = $this->userService->getUserByLogin($login);

        // Если пользователь не найден
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Устройство не найдено'
            ], 404);
        }

        $controlDevice = $this->controlDeviceService->getDeviceBySerialNumber($serialNumber, $user->account_id);

        // Если устройство не найдено
        if (!$controlDevice) {
            return response()->json([
                'success' => false,
                'message' => 'Устройство не найдено'
            ], 404);
        }

        // Если устройство не подтверждено
        if (!$controlDevice->confirm) {
            return response()->json([
                'success' => false,
                'message' => 'Устройство не подтверждено'
            ], 500);
        }

        // Если токен уже был получен ранее
        if (!$controlDevice->access_token) {
            return response()->json([
                'success' => false,
                'message' => 'Token для этого устройства уже был получен'
            ], 500);
        }

        $token = $this->controlDeviceService->getAuthTokenDevice($controlDevice);

        return response()->json([
            'success' => true,
        ])->header('Access-Token', $token);
    }
}
