<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DrinkResource;
use App\Models\Drink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DrinkController extends Controller
{
    public function list():JsonResponse
    {
        $drinks = Drink::all();

        return response()->json([
            'message' => 'Drink retrieved successfully',
            'data' => DrinkResource::collection($drinks)
        ]);
    }

    public function show(Drink $drink):JsonResponse
    {
        return response()->json([
            'message' => 'Drink retrieved successfully',
            'data' => new DrinkResource($drink)
        ]);

    }
}
