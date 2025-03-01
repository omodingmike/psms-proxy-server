<?php

    namespace App\Console;

    use AfricasTalking\SDK\AfricasTalking;
    use App\Models\Health;
    use App\Traits\SMS;
    use Illuminate\Console\Scheduling\Schedule;
    use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
    use Illuminate\Support\Facades\Http;

    class Kernel extends ConsoleKernel
    {
        use SMS;

        protected function schedule(Schedule $schedule) : void
        {
            $schedule->call(function () {

                $url            = 'https://api.airqo.net/api/v2/devices/measurements/sites/60d058c8048305120d2d614f/recent?token=E494DSTDT3S4MY93';
                $response       = Http::get($url);
                $data           = [
                    'value'    => data_get($response , 'measurements.0.pm2_5.value') ,
                    'category' => data_get($response , 'measurements.0.aqi_category') ,
                ];
                $africasTalking = new AfricasTalking(
                    username: 'sandbox' ,
                    apiKey  : 'atsk_bc861dbd58c51418fa608bf56a41807ea175859165339e4f060341d0610e4ba1e914ec38'
                );

                if ( $data['value'] > 10 ) {
                    $phone_number = '256704034249';
                    $message      = "Temperature is 36.5 The air condition is ". $data['category'];
                    $sms          = $africasTalking->sms();
                    $sms->send([
                        'to'      => $phone_number ,
                        'message' => $message
                    ]);
                }
                $post_data = [
                    'fields' => [
                        'category
'                                     => [
                            'stringValue' => $data['category']
                        ] ,
                        'air'         => [
                            'doubleValue' => $data['value']
                        ] ,
                        'temperature' => [
                            'doubleValue' => 34.6
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
               Http::withHeaders($headers)->post($post_url , $post_data);
            })->everyMinute();
        }

        protected function commands()
        {
            $this->load(__DIR__ . '/Commands');

            require base_path('routes/console.php');
        }
    }
