<?php

namespace App\Transformers;

use App\Models\ContentSetting;

class ContentSettingTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(ContentSetting $contentSetting): array
    {
        return [
            'id' => $contentSetting->id,
            'duration' => $contentSetting->duration,
            'repeat' => $contentSetting->repeat,
        ];
    }
}
