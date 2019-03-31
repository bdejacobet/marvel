<?php
namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

class MarvelController
{
    public function index()
    {
        $client = HttpClient::create();

        $url = 'https://symfony.com/versions.json';

        $response = $client->request('GET', $url);

        dump($response->toArray());

        return new Response(
            '<html><body>marvel to test api</body></html>'
        );
    }
}