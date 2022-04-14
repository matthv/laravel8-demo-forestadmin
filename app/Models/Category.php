<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartSegment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @package  Laravel-demo-forestadmin
 * @license  GNU https://www.gnu.org/licences/licences.html
 * @link     https://github.com/ForestAdmin/laravel-forestadmin
 */
class Category extends Model
{
    use HasFactory;
    use ForestCollection;

    /**
     * @return SmartSegment
     */
    public function bestCategories(): SmartSegment
    {
        return $this->smartSegment(
            fn(Builder $query) => $query->where('label', 'Dessie Kilback'),
            'bestName'
        );
    }
}
