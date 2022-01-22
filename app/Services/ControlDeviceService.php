<?php

namespace App\Services;

use App\Models\Account;
use App\Models\ControlDevice;
use Illuminate\Support\Str;

class ControlDeviceService
{
    // Регистрация нового устройства
    public function createDevice($data): ControlDevice
    {
        $controlDevice = new ControlDevice([
            'account_id' => auth()->user()->account_id,
            'title' => $data['title'],
            'serial_number' => $data['serial_number'],
            'access_token' => Str::uuid()->toString(),
        ]);
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
        return ControlDevice::where('id', $controlDeviceId)->first();
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
    public function getAuthDevice($serialNumber, $accessToken)
    {
        return ControlDevice::where([['serial_number', $serialNumber], ['access_token', $accessToken]])->first();
    }
}
