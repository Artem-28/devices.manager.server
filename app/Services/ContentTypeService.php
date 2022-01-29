<?php

namespace App\Services;

use App\Models\ContentType;

class ContentTypeService
{
    // Получение списка типов контента
    public function getContentTypes()
    {
        return ContentType::where('active', true)->get();
    }
}
