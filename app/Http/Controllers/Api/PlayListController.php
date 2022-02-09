<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PlayListService;
use App\Traits\DataPreparation;
use App\Transformers\PlayListTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

class PlayListController extends Controller
{
    use DataPreparation;
    private PlayListService $playListService;

    public function __construct(PlayListService $playListService)
    {
        $this->middleware(['auth:sanctum', 'auth.user']);
        $this->playListService = $playListService;
    }

    // Создание нового play листа
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->only(['title', 'description']);
            $playList = $this->playListService->createPlayList($data);
        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        $resource = new Item($playList, new PlayListTransformer());
        return response()->json([
            'success' => true,
            'playlist' => $this->createData($resource)
        ]);
    }

    // Получение списка play листов
    public function store(): \Illuminate\Http\JsonResponse
    {
        try {
            $playLists = $this->playListService->getPlayLists();

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        $resource = new Collection($playLists, new PlayListTransformer());
        return response()->json([
            'success' => true,
            'playlists' => $this->createData($resource)
        ]);
    }

    // Обновление play листа
    public function update(Request $request, $playListId): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->only(['title', 'description']);
            $playList = $this->playListService->updatePlayList($data, $playListId);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        $resource = new Item($playList, new PlayListTransformer());
        return response()->json([
            'success' => true,
            'playlist' => $this->createData($resource)
        ]);
    }

    // Удаление play листа
    public function delete($playListId): \Illuminate\Http\JsonResponse
    {
        try {
            $this->playListService->deletePlayList($playListId);

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
