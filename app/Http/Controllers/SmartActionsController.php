<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SmartActionsController extends Controller
{
    /**
     * @return Response
     */
    public function single(): Response
    {
        return response()->noContent();
    }

    /**
     * @return Response
     */
    public function bulk(): Response
    {
        return response()->noContent();
    }

    /**
     * @return JsonResponse
     */
    public function global(): JsonResponse
    {
        Book::where('active', true)->update(['other' => 'update with smart action']);

        return response()->json(
            ['success' => 'Books updated']
        );
    }
}
