<?php

namespace App\Services;

use App\Models\Account;
use App\Models\ControlDevice;
use App\Models\Role;
use Illuminate\Support\Str;

class ControlDeviceService
{
    // Регистрация нового устройства
    public function createDevice($data): ControlDevice
    {
        $controlDevice = new ControlDevice($data);
        $controlDevice->save();
        return $controlDevice;
    }

    // Получение списка устройств пользователя
    public function getListControlDevices()
    {
        $accountId = auth()->user()->account_id;
        return ControlDevice::where('account_id', $accountId)->get();
    }

    // Обновление устройства
    public function updateControlDevice($data, $controlDeviceId)
    {
        $accountId = auth()->user()->account_id;

        $account = Account::with([
            'controlDevices' => function ($query) use ($controlDeviceId, $data) {
                $query->find($controlDeviceId)
                    ->fill($data)
                    ->update();
            }])->find($accountId);

        return $account->controlDevices->first->toArray();
    }

    // Получение устройства по id
    public function getControlDeviceById($controlDeviceId)
    {
        $accountId = auth()->user()->account_id;
        return ControlDevice::where([['id', $controlDeviceId], ['account_id', $accountId]])->first();
    }

    // Подтверждение регистрации устройства
    public function confirmControlDevice(ControlDevice $controlDevice): ControlDevice
    {
        $token = $this->createToken($controlDevice);
        $controlDevice->access_token = $token;
        $controlDevice->confirm = true;
        $controlDevice->save();
        return $controlDevice;
    }

    // Удаление устройства
    public function deleteControlDevice($controlDeviceId)
    {
        $accountId = auth()->user()->account_id;

        Account::where('id', $accountId)->with([
            'controlDevices' => function ($query) use ($controlDeviceId) {
                $query->find($controlDeviceId)->delete();
            }])->first();
    }

    // Получение устройства по серийному номеру и токену
    public function getDeviceBySerialNumber($serialNumber, $accountId)
    {
        return ControlDevice::where([['serial_number', $serialNumber], ['account_id', $accountId]])->first();
    }

    // Создание токена для устройства
    public function createToken(ControlDevice $controlDevice): string
    {
        return $controlDevice->createToken('auth_token', [Role::CONTROL_DEVICE])->plainTextToken;
    }

    // Получение токена устройства
    public function getAuthTokenDevice(ControlDevice $controlDevice): string
    {
        $token = $controlDevice->access_token;
        $controlDevice->access_token = null;
        $controlDevice->save();
        return $token;
    }
}
