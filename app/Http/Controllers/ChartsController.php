<?php

namespace App\Http\Controllers;

use App\Models\Book;
use ForestAdmin\LaravelForestAdmin\Facades\ChartApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function value(): JsonResponse
    {
        $value = Book::find(1)->amount;

        return ChartApi::renderValue($value);
    }

    /**
     * @return JsonResponse
     */
    public function pie(): JsonResponse
    {
        $query = Book::select(DB::raw('label as key, amount as value'))->limit(3)->get()->toArray();

        return ChartApi::renderPie($query);
    }

    /**
     * @return JsonResponse
     */
    public function line(): JsonResponse
    {
        $query = Book::select(DB::raw('id as label, amount as value'))
            ->groupBy('id', 'amount')
            ->limit(5)
            ->get()
            ->toArray();

        $result = [];
        foreach ($query as $data) {
            $result[] = [
                'label'  => $data['label'],
                'values' => ['value' => $data['value']],
            ];
        }

        return ChartApi::renderLine($result);
    }

    /**
     * @return JsonResponse
     */
    public function objective(): JsonResponse
    {
        $query = Book::select('amount')
            ->where('amount', '>', 10)
            ->where('amount', '<', 100)
            ->min('amount');

        $data = ['value' => $query, 'objective' => 100];

        return ChartApi::renderObjective($data);
    }

    /**
     * @return JsonResponse
     */
    public function leaderboard(): JsonResponse
    {
        $query = Book::select(DB::raw('id as key, amount as value'))
            ->where('amount', '>', 0)
            ->where('amount', '<', 1000)
            ->orderby('amount', 'desc')
            ->limit(5)
            ->get()
            ->toArray();

        return ChartApi::renderLeaderboard($query);
    }
}
