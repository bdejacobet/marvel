<?php
namespace App\Controller;

use App\ApiClient\MarvelApiClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarvelController
{
    /**
     * MarvelApiClient
     */ 
    private $marvelApiClient;

    public function __construct(
        MarvelApiClient $marvelApiClient
    ) {
        $this->marvelApiClient = $marvelApiClient;
    }

    /**
     * @Route("/characters")
     */
    public function characters()
    {
        $response = $this->marvelApiClient->getCharacters();
        dump($response->toArray());

        $characterHtml = '';
        foreach ($response->toArray()['data']['results'] as $character) {
            $characterHtml .= sprintf('<li>%s</li>', $character['name']);
        }

        $html = sprintf('<html><body><ul>%s</ul></body></html>', $characterHtml);

        return new Response($html);
    }
}