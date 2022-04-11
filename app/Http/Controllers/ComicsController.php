<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use ForestAdmin\LaravelForestAdmin\Facades\JsonApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComicsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $query = Book::select('id', 'label', 'amount AS price')->whereDifficulty('easy');
        $pageParams = request()->query('page') ?? [];

        $comics = $query->paginate(
            $pageParams['size'] ?? null,
            '*',
            'page',
            $pageParams['number'] ?? null
        );

        return response()->json(
            JsonApi::render($comics, 'comic', ['count' => $comics->total()])
        );
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $comic = new Book();
        $comic->label = $request->input('data.attributes.label');
        $comic->amount = $request->input('data.attributes.price');
        $comic->comment = 'comments book';
        $comic->difficulty = 'easy';
        $comic->active = true;
        $comic->options = ['foo' => 'foo'];
        $comic->category_id = Category::all()->random()->id;
        $comic->save();

        //--- force field price only for demo / test. ⚠️ Do not repeat this at home ⚠️  ---//
        $comic->price = $comic->amount;

        return response()->json(
            JsonApi::render($comic, 'comic')
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $comic = Book::select('id', 'label', 'amount AS price')->firstWhere('id', $id);

        return response()->json(
            JsonApi::render($comic, 'comic')
        );
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $comic = Book::firstWhere('id', $id);
        $comic->label = $request->input('data.attributes.label', $comic->label);
        $comic->amount = $request->input('data.attributes.price', $comic->amount);
        $comic->save();

        //--- force field price only for demo / test. ⚠️ Do not repeat this at home ⚠️  ---//
        $comic->price = $comic->amount;

        return response()->json(
            JsonApi::render($comic, 'comic')
        );
    }

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Book::where('id', $id)->delete();

        return response()->noContent();
    }
}
