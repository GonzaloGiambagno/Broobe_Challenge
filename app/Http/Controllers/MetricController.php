<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetricStoreRequest;
use App\Models\Category;
use App\Models\MetricHistoryRun;
use App\Models\Strategy;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class MetricController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $strategies = Strategy::all();

        return view('pages.run_metric', [
            'categories' => $categories,
            'strategies' => $strategies,
        ]);
    }

    public function getMetrics(Request $request)
    {
        $url = $request->input('url');
        $categories = $request->input('categories');
        $strategy = $request->input('strategy');

        $apiKey = config('services.google_pagespeed.api_key');
        $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$url}&key={$apiKey}";


        foreach ($categories as $category) {
            $apiUrl .= "&category={$category}";
        }
        $apiUrl .= "&strategy={$strategy}";

        try {
            $client = new Client();
            $response = $client->get($apiUrl);
            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (RequestException $e) {
            return response()->json(['error' => 'Error en la solicitud a la API externa'], 500);
        }
    }

    public function storeMetric(MetricStoreRequest $request)
    {
        try {
            MetricHistoryRun::create($request->all());
            return response()->json('Las métricas se guardaron correctamente', 200);
        } catch (\Exception $e) {
            return response()->json('Error al guardar las métricas: ' . $e->getMessage(), 500);
        }
    }
}
