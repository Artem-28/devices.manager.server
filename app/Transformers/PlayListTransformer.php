<?php

namespace App\Transformers;

use App\Models\PlayList;

class PlayListTransformer extends \League\Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'contents',
    ];

    public function transform(PlayList $playlist): array
    {
        return [
            'id' => $playlist->id,
            'title' => $playlist->title,
            'description' => $playlist->description
        ];
    }

    public function includeContents(PlayList $playlist): \League\Fractal\Resource\Collection
    {
        $contents = $playlist->contents;
        return $this->collection($contents, new ContentSettingTransformer());
    }
}
