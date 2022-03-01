<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Faker\Factory;
use ForestAdmin\LaravelForestAdmin\Utils\Traits\RequestBulk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SmartActionsController extends Controller
{
    use RequestBulk;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function single(Request $request): JsonResponse
    {
        $id = $request->input('data.attributes.ids')[0];
        $book = Book::findOrFail($id);
        $book->active = true;
        $book->save();

        return response()->json(
            ['success' => "$book->id is now active !"]
        );
    }

    /**
     * @return Response
     */
    public function bulk(): Response
    {
        $ids = $this->getIdsFromBulkRequest();
        Book::whereIn('id', $ids)->update(['other' => 'update with smart action bulk']);

        // TODO SUCCESS ?

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

    /**
     * @return StreamedResponse
     */
    public function download(): StreamedResponse
    {
        Storage::put('file.txt', Str::random());

        return Storage::download('file.txt');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addComment(Request $request): JsonResponse
    {
        $id = $request->input('data.attributes.ids')[0];
        $body = $request->input('data.attributes.values.body');
        $book = Book::findOrFail($id);
        $book->comments()->create(
            [
                'body'    => $body,
                'user_id' => auth('forest')->user()->getKey(),
            ]
        );

        return response()->json(
            [
                'success' => 'Comment created',
                'refresh' => ['relationships' => ['comments']],
            ]
        );
    }
}
