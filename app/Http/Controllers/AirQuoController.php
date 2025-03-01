<?php

    namespace App\Http\Controllers;

    use App\Models\Health;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Http;

    class AirQuoController extends Controller
    {
        public function index()
        {
            $url      = "https://api.airqo.net/api/v2/devices/measurements/sites/60d058c8048305120d2d614f/recent?token=E494DSTDT3S4MY93";
            $response = Http::get($url);
            return response(data_get($response , 'measurements.0.pm2_5.value'));
        }

        public function actual()
        {
            return Health::latest()->take(1)->first();
//            return Health::all();
        }

        public function key()
        {
            Artisan::call('key:generate');
        }

        public function data()
        {
            $url      = "https://api.airqo.net/api/v2/devices/measurements/sites/60d058c8048305120d2d614f/recent?token=E494DSTDT3S4MY93";
            $response = Http::get($url);
            $data     = [
                'value'    => data_get($response , 'measurements.0.pm2_5.value') ,
                'category' => data_get($response , 'measurements.0.aqi_category') ,
            ];
            return response($data);
        }
    }
