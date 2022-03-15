<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartAction;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartField;
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

    protected $casts = [
        'delivery_date' => 'datetime',
    ];

    /**
     * @return SmartField
     */
    public function reference(): SmartField
    {
        return $this->smartField(['type' => 'string'])
            ->get(
                fn() => $this->label . '-' . $this->price
            )
            ->set(
                function ($value) {
                    [$label, $price] = explode('-', $value);
                    $this->label = $label;
                    $this->price = $price;

                    return $this;
                }
            );
    }

    /**
     * @return Collection
     */
    public function smartActions(): Collection
    {
        return collect(
            [
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
                    ->addField(['field' => 'foo', 'type' => 'string', 'is_required' => true, 'hook' => 'onFooChange'])
                    ->load(
                        function() {
                            $fields = $this->getFields();
                            $fields['token']['value'] = 'default';

                            return $fields;
                        }
                    )
                    ->change(
                        [
                            'onFooChange' => function () {
                                $fields = $this->getFields();
                                $fields['token']['value'] = 'Test onChange Foo';

                                return $fields;
                            }
                        ]
                    ),
                App::makeWith(
                    SmartAction::class,
                    [
                        'model'    => class_basename($this),
                        'name'     => 'smart action hook - load',
                        'type'     => 'single',
                        'execute' => function () {
                            return ['success' => 'test hook load'];
                        },
                    ]
                )
                ->addField(['field' => 'country', 'type' => 'Enum', 'is_required' => true, 'enums' => ['Ukraine', 'Poland','Latvia']])
            ]
        );
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
