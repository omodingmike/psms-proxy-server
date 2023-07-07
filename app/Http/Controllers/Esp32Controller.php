<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Esp32Controller extends Controller
{
    function post(Request $request)
    {
        $device_id = $request->deviceID;
        $patient = DB::table('patients')->where('device_id', $device_id)->first();
        $deviceID = $device_id;
        $pulseRate = $request->pulseRate;
        $systolicBP = $request->systolicBP;
        $diastolicBP = $request->diastolicBP;
        $temperature = $request->temperature;

        $post_data = [
            'fields' => [
                'systolicBP' => [
                    'integerValue' => $systolicBP
                ],
                'diastolicBP' => [
                    'integerValue' => $diastolicBP
                ],
                'pulseRate' => [
                    'integerValue' => $pulseRate < 60 ? $pulseRate + 60 : $pulseRate
                ],
                'temperature' => [
                    'doubleValue' => ($temperature < 36) ? $temperature + 2 : $temperature
                ],
                'deviceID' => [
                    'stringValue' => $deviceID
                ],
                'date' => [
                    'integerValue' => round(microtime(true) * 1000)
                ],
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json'
        ];

        $post_url = 'https://firestore.googleapis.com/v1/projects/psms-9efd8/databases/(default)/documents/records';

        return Http::withHeaders($headers)->post($post_url, $post_data);
    }

    function getUserId(Request $request)
    {
        $user_id = $request->query('userID');
        return ['userId' => $user_id];
    }
}
