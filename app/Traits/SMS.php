<?php

    namespace App\Traits;

    use AfricasTalking\SDK\AfricasTalking;
    use Illuminate\Support\Str;

    trait SMS
    {
        public function sendSMS(array $data) : bool
        {
            $africasTalking = new AfricasTalking(
                username: 'waayo',
                apiKey  : 'ba7637d50a9cf2d53fae77d7cbae1997fd9aec7e917c5770f5321aae0aafa9fb'
            );

            $phone_number = $data['to'];
            $message      = $data['message'];
            $shortcode    = "ATAgriTech";
            $sms = $africasTalking->sms();
            $response = $sms->send([
                'to'      => $phone_number ,
                'message' => $message ,
                'from'    => $shortcode
            ]);

            if ( isset($response['status']) ) {
                $response_message = strtolower(data_get($response , 'data.SMSMessageData.Message'));
                $sent_sms         = Str::before(Str::between($response_message , 'to' , 'total') , '/');
                if ( $sent_sms > 0 ) {
                    return true;
                }
            }
            return false;
        }
    }
