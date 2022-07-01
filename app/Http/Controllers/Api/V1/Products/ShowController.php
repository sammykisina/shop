<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Catalog\ProductResource;
use Domains\Catalog\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

class ShowController extends Controller {
    public function __invoke(Request $request,string $uuid): JsonResponse {
       $product = QueryBuilder::for(
            subject:Product::class,
       )->allowedIncludes(
            includes:['category','range','variants']
       )->where('uuid', $uuid)->firstOrFail();

       return response()->json(
            data: new ProductResource(
                resource: $product
            ),
            status: Http::OK
        );
    }
}
