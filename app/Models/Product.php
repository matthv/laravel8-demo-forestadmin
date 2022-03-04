<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartActions\SmartAction;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
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
     * @return Collection
     */
    public function smartActions(): Collection
    {
        return collect([
            App::makeWith(
                SmartAction::class,
                [
                    'model'    => class_basename($this),
                    'name'     => 'smart action hook',
                    'type'     => 'single',
                    'execute' => function () {
                        return [];
                    },
                ]
            )
                ->addField(['field' => 'token', 'type' => 'string', 'is_required' => true])
                ->load(
                    function() {
                        $fields = $this->getFields();
                        $fields->first()->setValue('default');

                        return $fields;
                    }
                ),
        ]);
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
