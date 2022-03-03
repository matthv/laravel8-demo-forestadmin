<?php

namespace App\Http\Controllers;

use App\Models\Product;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\AbstractSmartActionController;
use ForestAdmin\LaravelForestAdmin\Utils\Traits\RequestBulk;

/**
 * Class SmartActionProductsController
 *
 * @package  Laravel-demo-forestadmin
 * @license  GNU https://www.gnu.org/licences/licences.html
 * @link     https://github.com/ForestAdmin/laravel-forestadmin
 */
class SmartActionProductsController extends AbstractSmartActionController
{
    use RequestBulk;

    /**
     * @return string
     */
    public function getCollection(): string
    {
        return Product::class;
    }

    /**
     * @return void
     */
    public function hook()
    {
        //TODO
    }
}
