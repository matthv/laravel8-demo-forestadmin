<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartAction;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartField;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartRelationship;
use ForestAdmin\LaravelForestAdmin\Utils\Traits\RequestBulk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Book extends Model
{
    use ForestCollection;
    use HasFactory;
    use RequestBulk;

    /**
     * @return array
     */
    public function searchFields(): array
    {
        return ['id', 'label'];
    }

    protected $casts = [
        'options' => 'array',
        'active'  => 'boolean',
    ];

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function schemaFields(): array
    {
        return [
            ['field' => 'difficulty', 'enums' => ['easy', 'hard']],
        ];
    }

    /**
     * @return SmartAction
     */
    public function smartActionSingle(): SmartAction
    {
        return $this->smartAction(
            'single',
                function () {
                    $id = request()->input('data.attributes.ids')[0];
                    $book = Book::findOrFail($id);
                    $book->active = true;
                    $book->save();

                    return ['success' => "$book->id is now active !"];
                }
        );
    }

    /**
     * @return SmartAction
     */
    public function test(): SmartAction
    {
        return $this->smartAction(
            'single',
            fn () => ['success' => "test working!"]
        );
    }

    /**
     * @return SmartAction
     */
    public function smartActionBulk(): SmartAction
    {
        return $this->smartAction(
            'bulk',
            function () {
                $ids = $this->getIdsFromBulkRequest();
                Book::whereIn('id', $ids)->update(['other' => 'update with smart action bulk']);

                return [];
            },
            'smart action bulk'
        );
    }

    /**
     * @return SmartAction
     */
    public function smartActionGlobal(): SmartAction
    {
        return $this->smartAction(
            'global',
            function () {
                Book::where('active', true)->update(['other' => 'update with smart action']);

                return ['success' => 'Books updated'];
            },
            'smart action global'
        );
    }

    /**
     * @return SmartAction
     */
        public function smartActionDownload(): SmartAction
    {
        return $this->smartAction(
            'global',
            function () {
                Storage::put('file.txt', Str::random());

                return Storage::download('file.txt');
            },
            'smart action download'
        )
            ->download(true);
    }

    /**
     * @return SmartAction
     */
    public function addComment(): SmartAction
    {
        return $this->smartAction(
            'single',
            function () {
                $id = request()->input('data.attributes.ids')[0];
                $body = request()->input('data.attributes.values.body');
                $book = Book::findOrFail($id);
                $book->comments()->create(
                    [
                        'body'    => $body,
                        'user_id' => auth('forest')->user()->getKey(),
                    ]
                );

                return [
                    'success' => 'Comment created',
                    'refresh' => ['relationships' => ['comments']],
                ];
            },
        )
            ->addField(['field' => 'body', 'type' => 'string', 'is_required' => true]);
    }

    /**
     * @return SmartRelationship
     */
    public function smartBookstores(): SmartRelationship
    {
        return $this->smartRelationship(
            [
                'type' => ['String'],
                'reference' => 'bookstore.id'
            ]
        );
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function ranges(): BelongsToMany
    {
        return $this->belongsToMany(Range::class);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return HasMany
     */
    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }

    /**
     * @return HasManyThrough
     */
    public function bookstores(): HasManyThrough
    {
        return $this->hasManyThrough(Company::class, Bookstore::class);
    }

    /**
     * @return HasOne
     */
    public function editor(): HasOne
    {
        return $this->hasOne(Editor::class);
    }

    /**
     * @return HasOne
     */
    public function advertisement(): HasOne
    {
        return $this->hasOne(Advertisement::class);
    }

    /**
     * @return HasOneThrough
     */
    public function authorUser(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Author::class);
    }

    /**
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * @return MorphMany
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    /**
     * @return MorphMany
     */
    public function sequels(): MorphMany
    {
        return $this->morphMany(Sequel::class, 'sequelable');
    }

    /**
     * @return MorphToMany
     */
    public function buys(): MorphToMany
    {
        return $this->morphToMany(Buy::class, 'buyable');
    }
}
