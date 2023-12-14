<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'ACe67ac1050182dd91c410664ae83e65a9';
    private $authToken = 'ba096b94473dbc6105018130fde80ff0';
    private $twilioPhoneNumber = '+15185474530';

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
