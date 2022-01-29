<?php

namespace App\Transformers;

use App\Models\ContentType;

class ContentTypeTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(ContentType $contentType): array
    {
        return [
            'id' => $contentType->id,
            'title' => $contentType->title,
            'slug' => $contentType->slug,
            'description' => $contentType->description,
            'icon' => $contentType->icon,
        ];
    }
}
