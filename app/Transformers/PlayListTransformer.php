<?php

namespace App\Transformers;

use App\Models\PlayList;

class PlayListTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(PlayList $playList): array
    {
        return [
            'id' => $playList->id,
            'title' => $playList->title,
            'description' => $playList->description
        ];
    }
}
