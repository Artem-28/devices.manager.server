<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ContentTypeService;
use App\Traits\DataPreparation;
use App\Transformers\ContentTypeTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;

class ContentTypeController extends Controller
{
    use DataPreparation;
    private ContentTypeService $contentTypeService;

    public function __construct(ContentTypeService $contentTypeService)
    {
        $this->middleware(['auth:sanctum', 'auth.user']);
        $this->contentTypeService = $contentTypeService;
    }

    // Получение типов контента
    public function store(): \Illuminate\Http\JsonResponse
    {
        try {
            $types = $this->contentTypeService->getContentTypes();

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

        $resource = new Collection($types, new ContentTypeTransformer());
        return response()->json([
            'success' => true,
            'contentTypes' => $this->createData($resource)
        ]);
    }
}
