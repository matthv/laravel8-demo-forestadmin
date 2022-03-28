<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartAction;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        return $this->smartField(
            [
                'type'          => 'string',
                'is_filterable' => true,
                'is_sortable'   => true,
            ]
        )
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
            )
            ->sort(
                function (Builder $query, string $direction) {
                    return $query->orderBy('price', $direction)
                        ->orderBy('label', 'ASC');
                }
            )
            ->search(
                function (Builder $query, $value) {
                    return $query->orWhere(
                        fn($query) => $query->whereRaw("LOWER(label) LIKE LOWER(?)", ['%' . $value . '%'])
                            ->orWhereRaw("LOWER(price::text) LIKE LOWER(?)", ['%' . $value . '%'])
                    );
                }
            )
            ->filter(
                function (Builder $query, $value, string $operator, string $aggregator) {
                    switch ($operator) {
                        case 'present':
                            $query->where(
                                fn($query) => $query->where(
                                    fn($query) => $query->whereNotNull('label')->orWhere('label', '!=', '')
                                )->orWhere(
                                    fn($query) => $query->whereNotNull('price')
                                ),
                                null,
                                null,
                                $aggregator
                            );
                            break;
                        case 'blank':
                            $query->where(
                                fn($query) => $query->where(
                                    fn($query) => $query->whereNull('label')->orWhere('label', '=', '')
                                )->orWhere(
                                    fn($query) => $query->whereNull('price')->orWhere('price', '=', '')
                                ),
                                null,
                                null,
                                $aggregator
                            );
                            break;
                        case 'contains':
                            $query->where(fn($query) => $query->whereRaw("LOWER(label) LIKE LOWER(?)", ['%' . $value . '%'])
                                ->orWhereRaw("LOWER(price::text) LIKE LOWER(?)", ['%' . $value . '%']),
                                null,
                                null,
                                $aggregator
                            );
                            break;
                        default:
                            throw new ForestException(
                                "Unsupported operator: $operator"
                            );
                    }

                    return $query;
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
                        'model'   => class_basename($this),
                        'name'    => 'smart action hook',
                        'type'    => 'single',
                        'execute' => function () {
                            return [];
                        },
                    ]
                )
                    ->addField(['field' => 'token', 'type' => 'string', 'is_required' => true])
                    ->addField(['field' => 'foo', 'type' => 'string', 'is_required' => true, 'hook' => 'onFooChange'])
                    ->load(
                        function () {
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
                            },
                        ]
                    ),
                App::makeWith(
                    SmartAction::class,
                    [
                        'model'   => class_basename($this),
                        'name'    => 'smart action hook - load',
                        'type'    => 'single',
                        'execute' => function () {
                            return ['success' => 'test hook load'];
                        },
                    ]
                )
                    ->addField(['field' => 'country', 'type' => 'Enum', 'is_required' => true, 'enums' => ['Ukraine', 'Poland', 'Latvia']]),
            ]
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
