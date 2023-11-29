<?php

namespace App\Controller;

use App\Service\TwilioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmsController extends AbstractController
{
    #[Route('/send-sms', name: 'send_sms')]
    public function sendSms(TwilioService $twilioService): Response
    {
        $to = '+21650378582'; // Le numéro de téléphone destinataire
        $message = 'test 123 '; // Le message que vous souhaitez envoyer

        // $twilioService->sendSMS($to, $message);

        return new Response('SMS envoyé !');
    }
}
