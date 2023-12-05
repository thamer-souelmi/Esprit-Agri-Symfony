<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'AC31007dd09389f3348c4722b2221d71d7';
    private $authToken = 'c5ae1d3559b19b9279ed78c248a4e287';
    private $twilioPhoneNumber = '+13239874629';

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
