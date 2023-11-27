<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'ACf00a1728d61035d15656e1bceb79c66d';
    private $authToken = '2b256e845bc54dfb1d6478506a19684e';
    private $twilioPhoneNumber = '+19512511792';

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
