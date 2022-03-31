<?php

namespace App\Http\Controllers;

use App\Models\Book;
use ForestAdmin\LaravelForestAdmin\Facades\JsonApi;
use Illuminate\Http\JsonResponse;

class ComicsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $comics = Book::select('id', 'label', 'amount AS price')->whereDifficulty('easy')->get();

        return response()->json(
            JsonApi::render($comics, 'comic')
        );
    }
}
