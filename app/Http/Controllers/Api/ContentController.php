<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ContentService;
use App\Services\ContentTypeService;
use App\Services\FileService;
use App\Services\PlayListService;
use App\Traits\DataPreparation;
use App\Transformers\ContentTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ContentController extends Controller
{
    use DataPreparation;
    private PlayListService $playListService;
    private ContentService $contentService;
    private ContentTypeService $contentTypeService;
    private FileService $fileService;

    public function __construct
    (
        PlayListService $playListService,
        ContentService $contentService,
        ContentTypeService $contentTypeService,
        FileService $fileService
    )
    {
        $this->middleware(['auth:sanctum', 'auth.user']);

        $this->playListService = $playListService;
        $this->contentService = $contentService;
        $this->contentTypeService = $contentTypeService;
        $this->fileService = $fileService;
    }

    // Создание контента для плейлиста
    public function create(Request $request, $playListId): \Illuminate\Http\JsonResponse
    {
        try {
            $playList = $this->playListService->getPlayListById($playListId);

            if(!$playList) {
                return response()->json([
                    'success' => false,
                    'message' => "Playlist not found"
                ], 404);
            }

            $data = $request->only(['content', 'setting']);
            $contentType = $data['content']['content_type'];

            // Проверяем нужен ли файл для этого типа контента
            if($this->contentTypeService->isNeedAFile($contentType)) {
                $filePath = $data['content']['value'];
                $file = $this->fileService->getFileByPath($filePath, $playList->account_id);
                $data['content']['file_id'] = $file->id;
            }

            $content = $this->contentService->createContent($data, $playList);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        $resource = new Item($content, new ContentTransformer());
        return response()->json([
            'success' => true,
            'content' => $this->createData($resource)
        ]);
    }

    // Получение списка контента плейлиста
    public function store($playListId): \Illuminate\Http\JsonResponse
    {
        try {
            $contents = $this->contentService->getPlayListContents($playListId);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        $resource = new Collection($contents, new ContentTransformer());
        return response()->json([
            'success' => true,
            'contents' => $this->createData($resource)
        ]);
    }

    // Обновление контента
    public function update(Request $request, $playListId, $contentId): \Illuminate\Http\JsonResponse
    {
        try {
            $contentData = $request->get('content');
            $settingData = $request->get('setting');

            $content = DB::transaction(function () use (
                $contentData,
                $settingData,
                $playListId,
                $contentId
            ) {
                // Получаем контент
                $content = $this->contentService->getContentById($playListId, $contentId);

                // Если изменился файл привязываем новый файл
                if($content && $contentData && array_key_exists('value', $contentData)) {
                    $file = $this->fileService->getFileByPath($contentData['value'], $content->account_id);
                    if(!$file) {
                        throw new \Exception('Файл не найден');
                    }
                    $content->file()->associate($file);
                }

                // Обновление контента
                if($content && $contentData) {
                    $content->update($contentData);
                }

                // Обновление настроек контента
                if($content && $settingData) {
                    $content->setting->update($settingData);
                }
                return $content;
            });

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        $resource = new Item($content, new ContentTransformer());
        return response()->json([
            'success' => true,
            'content' => $this->createData($resource)
        ]);
    }

    // Удаление контента из плейлиста
    public function delete($playListId, $contentId): \Illuminate\Http\JsonResponse
    {
        try {
            $this->contentService->deleteContent($playListId, $contentId);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
