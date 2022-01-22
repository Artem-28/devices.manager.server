<?php

namespace App\Serializer;

class CollectArraySerializer extends \League\Fractal\Serializer\ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return $data;
    }
}
