<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartActions\SmartAction;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;
    use ForestCollection;

    protected $fillable = [
        'label',
        'price',
        'delivery_date',
        'user_id',
    ];

    /**
     * @return array
     * @throws BindingResolutionException
     */
    public function smartActions(): array
    {
        return [
            App::makeWith(
                SmartAction::class,
                [
                    'model'    => class_basename($this),
                    'name'     => 'smart action hook',
                    'endpoint' => '/forest/smart-actions/smart-action-hook',
                    'type'     => 'bulk',
                ]
            )
                ->download(true)
                ->addField('dsfq,fdqs')
                ->addField('sddsqdsq')
                ->hooks([], false),
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
