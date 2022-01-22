<?php

namespace App\Transformers;

use App\Models\ControlDevice;
use League\Fractal;

class ControlDeviceTransformer extends Fractal\TransformerAbstract
{
    public function transform(ControlDevice $controlDevice): array
    {
        return [
            'id' => $controlDevice->id,
            'serialNumber' => $controlDevice->serial_number,
            'accessToken' => $controlDevice->access_token,
            'title' => $controlDevice->title,
            'status' => $controlDevice->status(),
        ];
    }
}
