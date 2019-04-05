<?php
namespace App\Controller;

use App\ApiClient\MarvelApiClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarvelController
{
    private $marvelApiClient;

    public function __construct(
        MarvelApiClient $marvelApiClient
    ) {
        $this->marvelApiClient = $marvelApiClient;
    }

    /**
     * @Route("/")
     */
    public function index(): Response
    {
        return new Response('<html><body><ul>Pour jouer avec l\'api marvel et symfony/httpClient</ul></body></html>');
    }

    /**
     * @Route("/characters")
     */
    public function characters(): Response
    {
        $characters = $this->marvelApiClient->getCharacters();

        $characterHtml = '';
        foreach ($characters as $character) {
            $characterHtml .= sprintf('<li>%s</li>', $character['name']);
        }

        $html = sprintf('<html><body><ul>%s</ul></body></html>', $characterHtml);

        return new Response($html);
    }

    /**
     * @Route("/characters-one-by-one")
     */
    public function charactersOneByOne(): Response
    {
        $characters = $this->marvelApiClient->getCharactersOneByOne();

        dump($characters);

        $characterHtml = '';
        foreach ($characters as $character) {
            $characterHtml .= sprintf('<li>%s</li>', $character['name']);
        }

        $html = sprintf('<html><body><ul>%s</ul></body></html>', $characterHtml);

        return new Response($html);
    }
}