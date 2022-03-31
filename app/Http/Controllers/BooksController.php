<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookstore;
use ForestAdmin\LaravelForestAdmin\Facades\JsonApi;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\ForestController;
use Illuminate\Http\JsonResponse;

/**
 * Class BooksController
 *
 * @package  Laravel-demo-forestadmin
 * @license  GNU https://www.gnu.org/licences/licences.html
 * @link     https://github.com/ForestAdmin/laravel-forestadmin
 */
class BooksController extends ForestController
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function bookstores(int $id): JsonResponse
    {
        $bookStores = Bookstore::leftJoin('companies', 'companies.id', '=', 'bookstores.company_id')
            ->leftJoin('books','companies.book_id', '=', 'books.id')
            ->where('books.id', $id)
            ->paginate();

        return response()->json(
            JsonApi::render($bookStores, 'books')
        );
    }
}
