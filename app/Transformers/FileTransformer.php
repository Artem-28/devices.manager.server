<?php

namespace App\Transformers;

use App\Models\File;

class FileTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(File $file): array
    {
        return [
            'id' => $file->id,
            'path' => $file->path,
            'originalName' => $file->original_name,
            'size' => $file->size()
        ];
    }
}
