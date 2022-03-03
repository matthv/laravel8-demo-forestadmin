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
     * SmartActionProductsController Constructor
     */
    public function getCollection(): string
    {
        return Product::class;
    }

    public function getCollection(): string
    {
        // TODO: Implement getCollection() method.
    }

    /**
     * @return void
     */
    public function removeToken()
    {
        //TODO
    }
}
