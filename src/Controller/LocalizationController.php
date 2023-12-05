<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LocalizationController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/localization', name: 'localization')]
    public function index(Request $request): JsonResponse
    {
        // Remplacez '836972563a2870b55e11f1e6f9fab70ab24132d7' par votre clé API Google Maps
        $apiKey = '9fc6097415a512a66de6cba8b267b4fb9e8befc4';

        // Récupérer l'adresse depuis la requête
        $address = $request->query->get('address');

        // Construire l'URL pour l'API Google Maps
        $url = sprintf(
            'https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s',
            urlencode($address),
            $apiKey
        );

        // Faire la requête à l'API Google Maps
        $response = $this->client->request('GET', $url);
        $data = $response->toArray();

        // Récupérer les coordonnées de localisation (latitude et longitude)
        $location = null;
        if (isset($data['results'][0]['geometry']['location'])) {
            $location = $data['results'][0]['geometry']['location'];
        }

        // Retourner les coordonnées de localisation en tant que réponse JSON
        return $this->render('annoncerecrutement/new.html.twig');
    }
}
