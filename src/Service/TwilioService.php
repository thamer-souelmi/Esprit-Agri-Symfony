<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'AC2e270410bcf7cd0cfe9dd236aec743b6';
    private $authToken = 'a390519a29851cb0d23d74bf713d5002';
    private $twilioPhoneNumber = '+12016546949';

    public function sendSMS($to, $body)
    {
        $client = new Client($this->accountSid, $this->authToken);
        $client->messages->create(
            $to,
            [
                'from' => $this->twilioPhoneNumber,
                'body' => $body,
            ]
        );
    }
}
