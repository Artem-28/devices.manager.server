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

    // Проверяет нужен ли файл для типа контента
    public function isNeedAFile($contentType): bool
    {
        switch ($contentType) {
            case ContentType::IMAGE_TYPE:
            case ContentType::VIDEO_TYPE:
                return true;
            default:
                return false;
        }
    }
}
