<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ContentService;
use App\Services\PlayListService;
use App\Traits\DataPreparation;
use App\Transformers\ContentTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ContentController extends Controller
{
    use DataPreparation;
    private $playListService;
    private $contentService;

    public function __construct
    (
        PlayListService $playListService,
        ContentService $contentService
    )
    {
        $this->middleware('auth:sanctum');

        $this->playListService = $playListService;
        $this->contentService = $contentService;
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
            $data = $request->only(['content', 'setting']);
            $content = $this->contentService->updateContent($data, $playListId, $contentId);

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
