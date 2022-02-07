<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Traits\DataPreparation;
use App\Transformers\FileTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;

class ContentFileController extends Controller
{
    use DataPreparation;
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->middleware('auth:sanctum');

        $this->fileService = $fileService;
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $fileData = $request->file('file');
            $file= $this->fileService->uploadContentFile($fileData);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        $resource = new Item($file, new FileTransformer());
        return response()->json([
            'success' => true,
            'file' => $this->createData($resource)
        ]);
    }

    public function store()
    {

    }
}
