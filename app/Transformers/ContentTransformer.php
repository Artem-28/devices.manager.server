<?php

namespace App\Transformers;

use App\Models\Content;

class ContentTransformer extends \League\Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'setting'
    ];

    public function transform(Content $content): array
    {
        return [
            'id' => $content->id,
            'accountId' => $content->account_id,
            'playListId' => $content->play_list_id,
            'contentType' => $content->content_type,
            'order' => $content->order,
            'title' => $content->title,
            'value' => $content->value,
            'description' => $content->description,
        ];
    }

    public function includeSetting(Content $content): \League\Fractal\Resource\Item
    {
        $setting = $content->setting;
        return $this->item($setting, new ContentSettingTransformer());
    }
}
