<?php

    namespace App\Http\Controllers;

    use AfricasTalking\SDK\AfricasTalking;
    use App\Models\Health;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;

    class Esp32Controller extends Controller
    {
        function post(Request $request)
        {
//        $device_id = $request->deviceID;
//        $patient = DB::table('patients')->where('device_id', $device_id)->first();
//        $deviceID = $device_id;
//        $pulseRate = $request->pulseRate;
//        $systolicBP = $request->systolicBP;
//        $diastolicBP = $request->diastolicBP;
            $temperature = $request->temperature;
            info($temperature);

            $url      = 'https://api.airqo.net/api/v2/devices/measurements/sites/60d058c8048305120d2d614f/recent?token=E494DSTDT3S4MY93';
            $response = Http::get($url);
            $data     = [
                'value'    => data_get($response , 'measurements.0.pm2_5.value') ,
                'category' => data_get($response , 'measurements.0.aqi_category') ,
            ];

            Health::create(
                [
                    'temperature' => $temperature ,
                    'category'    => $data['category'] ,
                    'air'         => $data['value']
                ]
            );
            $africasTalking = new AfricasTalking(
                username: 'sandbox' ,
                apiKey  : 'atsk_bc861dbd58c51418fa608bf56a41807ea175859165339e4f060341d0610e4ba1e914ec38'
            );

            if ( $temperature > 38 ) {
                $phone_number = '256704034249';
                $message      = 'Temperature is ' . $temperature . ' The air condition is ' . $data['category'];
                $sms          = $africasTalking->sms();
                $sms->send([
                    'to'      => $phone_number ,
                    'message' => $message
                ]);
            }

            $post_data = [
                'fields' => [
                    'category
'                                 => [
                        'stringValue' => $data['category']
                    ] ,
                    'air'         => [
                        'doubleValue' => $data['value']
                    ] ,
                    'temperature' => [
                        'doubleValue' => $temperature
                    ] ,
                    'date'        => [
                        'integerValue' => round(microtime(true) * 1000)
                    ] ,
                ]
            ];
            $headers   = [
                'Content-Type' => 'application/json'
            ];

            $post_url = 'https://firestore.googleapis.com/v1/projects/at-hackthon/databases/(default)/documents/records';
           $data = Http::withHeaders($headers)->post($post_url , $post_data);
           info($data);

//             $africasTalking->voice();
//            $text = "Africa's Talking Hackathon event taking place at Acacia place on 22/07/2023 call 0756345678 to register. Thank you";
/*            $voice_response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Response>'<Say>'${text}'</Say>'</Response>";*/
//            return response($voice_response, 200)->header('Content-Type', 'text/plain');
        }

        function getUserId(Request $request)
        {
            $user_id = $request->query('userID');
            return [ 'userId' => $user_id ];
        }
    }
