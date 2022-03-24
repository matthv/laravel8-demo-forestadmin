<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
    use HasFactory, ForestCollection;

    /**
     * @return SmartField
     */
    public function bookCategory(): SmartRelationship
    {
        return $this->smartRelationship(
            [
                'type' => 'String',
                'reference' => 'category.id'
            ]
        )
            ->get(
                function () {
                    $category = Category::select('categories.*')
                        ->join('books', 'books.category_id', '=', 'categories.id')
                        ->where('books.id', $this->book_id)
                        ->first();

                    return $category;
                }
            );
    }

    /**
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
