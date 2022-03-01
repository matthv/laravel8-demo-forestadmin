<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartActions\SmartAction;
use ForestAdmin\LaravelForestAdmin\Services\SmartActions\Field;
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
use Illuminate\Support\Facades\App;

class Book extends Model
{
    use HasFactory;
    use ForestCollection;

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
            // todo à virer
            //['field' => 'label', 'is_required' => false],
            ['field' => 'difficulty', 'enums' => ['easy', 'hard']],
        ];
    }

    /**
     * @return array
     */
    public function smartActions(): array
    {
        return [
            App::makeWith(SmartAction::class,
                [
                    'model' => class_basename($this),
                    'name'  => 'smart action single',
                    'endpoint' => '/forest/smart-actions/smart-action-single',
                    'type' => 'single',
                ]
            ),
            App::makeWith(SmartAction::class,
                [
                    'model' => class_basename($this),
                    'name'  => 'smart action bulk',
                    'endpoint' => '/forest/smart-actions/smart-action-bulk',
                    'type' => 'bulk',
                ]
            ),
            App::makeWith(SmartAction::class,
                [
                    'model' => class_basename($this),
                    'name'  => 'smart action global',
                    'endpoint' => '/forest/smart-actions/smart-action-global',
                    'type' => 'global',
                ]
            ),
            App::makeWith(SmartAction::class,
                [
                    'model' => class_basename($this),
                    'name'  => 'smart action download',
                    'endpoint' => '/forest/smart-actions/smart-action-download',
                    'type' => 'global',
                ]
            )
                ->download(true),
            App::makeWith(SmartAction::class,
                [
                    'model' => class_basename($this),
                    'name'  => 'add comment',
                    'endpoint' => '/forest/smart-actions/add-comment',
                    'type' => 'single',
                ]
            )
                ->addField(['field' => 'body', 'type' => 'string', 'is_required' => true])
        ];
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
