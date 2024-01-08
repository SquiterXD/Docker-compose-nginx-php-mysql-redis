<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmIngredientRequestH;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PM0021ApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $queries = $request->all();
            $queryBuilder = PtpmIngredientRequestH::query()
                ->with('status');

            $requestNum = trim($queries['requestNum'] ?? '');
            if (!empty($requestNum)) {
                $queryBuilder = $queryBuilder
                    ->whereRaw("LOWER(request_num) like ?", [strtolower("%$requestNum%")]);
            }

            $date = trim($queries['date'] ?? '');
            if (!empty($date)) {
                $queryBuilder = $queryBuilder
                    ->whereDate('request_date', '=', $date);
            }

            $status = trim($queries['status'] ?? '');
            if (!empty($status)) {
                $queryBuilder = $queryBuilder
                    ->where('status', '=', $status);
            }

            $ingredientRequests = $queryBuilder
                ->get()
                ->take(100)
                ->toArray();

            return response()->json([
                'ingredient_requests' => $ingredientRequests,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'err' => $e,
            ], 500);
        }
    }
}
