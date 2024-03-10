<?php

namespace App\Http\Controllers;

use App\Models\MetricHistoryRun;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function showHistory(){
        $metrics = MetricHistoryRun::all();

        $metrics->transform(function ($metric) {
            $metric['date'] = Carbon::parse($metric['created_at'])->format('m-d-Y H:i');
            return $metric;
        });

        return view('pages.history', [
            'history' => $metrics,
        ]);
    }
}