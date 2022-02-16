<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/forest/charts/example-value',
        '/forest/charts/example-pie',
        '/forest/charts/example-line',
        '/forest/charts/example-objective',
        '/forest/charts/example-leaderboard',
    ];
}
