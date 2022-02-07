<?php

namespace App\Services;

use App\Models\File;

class FileService
{

    // Получение пути загрузки файла
    public function getUploadPath($file, $accountId)
    {
        switch ($this->getFileType($file)) {
            case 'image':
                return 'contents/' . $accountId . '/images';
            case 'video':
                return 'contents/' . $accountId . '/video';
            default:
                return new \Exception('Формат файла не поддерживается');
        }
    }

    // Получение типа файла
    public function getFileType($file)
    {
        $dataType = $file->getClientMimeType();
        return explode('/', $dataType, -1)[0];
    }

    // Загрузка файла для контента
    public function uploadContentFile($fileData)
    {
        $account = auth()->user()->account;
        $originalName = $fileData->getClientOriginalName();
        $localPath = $this->getUploadPath($fileData, $account->id);
        $path = $fileData->store($localPath);

        $file = new File([
            'original_name' => $originalName,
            'path' => $path
        ]);
        return $account->files()->save($file);
    }

    // Получение записи файла по path
    public function getFileByPath($path, $accountId)
    {
        return File::where([['account_id', $accountId], ['path', $path]])->first();
    }

    // Получение списка всех файлов для контента
    public function getFileContents()
    {
        $accountId = auth()->user()->account_id;
        return File::where('account_id', $accountId)->get();
    }

}
