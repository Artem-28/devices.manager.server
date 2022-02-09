<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ControlDeviceService;
use App\Traits\DataPreparation;
use App\Transformers\ControlDeviceTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;



class ControlDeviceController extends Controller
{
    use DataPreparation;
    private ControlDeviceService $controlDeviceService;

    public function __construct(ControlDeviceService $controlDeviceService)
    {
        $this->middleware(['auth:sanctum', 'auth.user']);
        $this->controlDeviceService = $controlDeviceService;
    }

    // Добавление нового устройства
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {

            $data = $request->all();
            $controlDevice = $this->controlDeviceService->createDevice($data);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        $resource = new Item($controlDevice, new ControlDeviceTransformer());

        return response()->json([
            'success' => true,
            'controlDevice' => $this->createData($resource)
        ]);

    }

    // Получение списка устройств для пользователя
    public function store(): \Illuminate\Http\JsonResponse
    {
        try {
            $controlDevices =  $this->controlDeviceService->getListControlDevices();

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
        $resource = new Collection($controlDevices, new ControlDeviceTransformer());
        return response()->json([
            'success' => true,
            'controlDevices' => $this->createData($resource),
        ]);
    }

    // Обновление устройства
    public function update(Request $request, $controlDeviceId): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->only('title');
            $controlDevice = $this->controlDeviceService->updateControlDevice($data, $controlDeviceId);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);

        }
        $resource = new Item($controlDevice, new ControlDeviceTransformer());
        return response()->json([
            'success' => true,
            'controlDevice' => $this->createData($resource)
        ]);
    }

    // Удаление устройства
    public function delete($controlDeviceId): \Illuminate\Http\JsonResponse
    {
        try {

            $this->controlDeviceService->deleteControlDevice($controlDeviceId);

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

    // Подтверждение регистрации устройства
    public function confirm($controlDeviceId): \Illuminate\Http\JsonResponse
    {
        try {
            $device = $this->controlDeviceService->getControlDeviceById($controlDeviceId);
            // Если нет устройства или оно не принадлежит пользователю
            if (!$device) {
                return response()->json([
                    'success' => false,
                    'message' => 'Устройство не найдено'
                ], 404);
            }

            // Если устройство было подтверждено ранее
            /*if ($device->confirm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Устройство было подтверждено ранее'
                ], 500);
            }*/

            $device = $this->controlDeviceService->confirmControlDevice($device);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        $resource = new Item($device, new ControlDeviceTransformer());
        return response()->json([
            'success' => true,
            'controlDevice' => $this->createData($resource)
        ]);
    }
}
