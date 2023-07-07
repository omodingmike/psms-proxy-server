<?php

namespace App\Http\Controllers;

use App\Models\QualityOfLife;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class QualityOfLifeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return QualityOfLife
     */
    public function index()
    {
        return QualityOfLife::first();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return QualityOfLife::create([
            'fanOn' => $request->fanOn,
            'alarmOn' => $request->alarmOn,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    public function toggleFan(Request $request)
    {
        QualityOfLife::first()
            ->update([
                'fanOn' => $request->fanOn,
            ]);
        return QualityOfLife::first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return bool
     */
    public function update(Request $request)
    {
        return QualityOfLife::first()
            ->update([
                'fanOn' => $request->fanOn,
                'alarmOn' => $request->alarmOn,
            ]);
    }

    public function toggleAlarm(Request $request)
    {
        QualityOfLife::first()
            ->update([
                'alarmOn' => $request->alarmOn,
            ]);
        return QualityOfLife::first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function firestore(Request $request)
    {
        $temperature = $request->temperature;
        $airQuality = $request->airQuality;
        $humidity = $request->humidity;

        $post_data = [
            'fields' => [
                'airQuality' => [
                    'integerValue' => $airQuality
                ],
                'humidity' => [
                    'integerValue' => $humidity
                ],
                'temperature' => [
                    'doubleValue' => $temperature
                ],
                'date' => [
                    'integerValue' => round(microtime(true) * 1000)
                ],
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json'
        ];

        $post_url = 'https://firestore.googleapis.com/v1/projects/qualityoflife-73b71/databases/(default)/documents/qol';

        return Http::withHeaders($headers)->post($post_url, $post_data);
    }
}
