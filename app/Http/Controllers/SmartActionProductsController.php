<?php

namespace App\Http\Controllers;

use App\Models\Product;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\SmartActionController;
use ForestAdmin\LaravelForestAdmin\Utils\Traits\RequestBulk;

/**
 * Class SmartActionProductsController
 *
 * @package  Laravel-demo-forestadmin
 * @license  GNU https://www.gnu.org/licences/licences.html
 * @link     https://github.com/ForestAdmin/laravel-forestadmin
 */
class SmartActionProductsController extends SmartActionController
{
    use RequestBulk;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(app(Product::class));
    }


    /**
     * @return void
     */
    public function hook()
    {
        //TODO
    }
}
