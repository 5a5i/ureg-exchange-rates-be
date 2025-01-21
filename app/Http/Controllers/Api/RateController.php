<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rate;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class RateController extends Controller
{
    // External API Base URL
    private $extUrl;
    private $apiKey;

    public function __construct()
    {
        $this->extUrl = config('external.exchange.url', 'https://api.exchangeratesapi.io');
        $this->apiKey = config('external.exchange.key', '');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $base = $request->input('base', 1);
        // dd(now()->toDateString(), now());
        // dd($date, $base);

        $rates = Rate::with(['baseCurrency', 'targetCurrency'])
                    ->where('base_currency_id', $base)
                    ->whereDate('effective_date', $date)
                    ->get();

        // dd($rates->isEmpty());

        if ($rates->isEmpty()) {
            return response()->json([], 204);
        }

        return response()->json($rates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'base' => 'required|string|exists:currencies,code',
            'date' => 'required|date',
            'rates' => 'required|array',
        ]);

        $date = Carbon::parse($request->date)->format('Y-m-d');
        $base = Currency::where('code', $request->base)->first();
        $baseId = $base->id;
        $rates = $request->rates;

        foreach ($rates as $code => $rate) {
            // $target = Currency::where('code', $code)->first();
            $target = Currency::firstOrCreate(['code' => $code]);

            if ($target) {
                Rate::updateOrCreate(
                    [
                        'base_currency_id' => $baseId,
                        'target_currency_id' => $target->id,
                        'effective_date' => $date,
                    ],
                    [
                        'rate' => $rate,
                    ]
                );
            }
        }

        return response()->json(['message' => 'Exchange rates stored successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $date)
    {
        // dd($request->all());
        $rates = [
            "error" => [
                "code" => $request->base != 'USD' ? "invalid_date" : "base_currency_access_restricted",
                "message" => "You have entered an invalid date. [Required format: date=YYYY-MM-DD]"
            ]
        ];
        // $rates["error"]["code"] = "base_currency_access_restricted";
        return response()->json($rates, 400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'base' => 'required|integer|exists:currencies,id',
            'date' => 'required|date',
        ]);

        $baseId = $request->base;
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $base = Currency::find($baseId);
        // dd("$this->extUrl/$date?access_key=$this->apiKey&base=$base->code");

        // Fetch data from the external API
        $response = Http::get("$this->extUrl/$date", [
            'access_key' => $this->apiKey,
            'base' => $base->code,
        ]);
        // dd($response);

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to fetch exchange rates from the external API'], 500);
        }

        $data = $response->json();
        $date = $data['date'] ?? $date;
        $rates = $data['rates'] ?? [];

        if (empty($rates)) {
            return response()->json(['message' => 'No exchange rates found in the external API', 'external' => $data], 404);
        }

        // $base = Currency::where('code', $base)->first();

        foreach ($rates as $code => $rate) {
            // $target = Currency::where('code', $code)->first();
            $target = Currency::firstOrCreate(['code' => $code]);

            if ($target) {
                Rate::updateOrCreate(
                    [
                        'base_currency_id' => $baseId,
                        'target_currency_id' => $target->id,
                        'effective_date' => $date,
                    ],
                    [
                        'rate' => $rate,
                    ]
                );
            }
        }

        return response()->json(['message' => 'Exchange rates updated successfully', 'rates' => $rates], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
