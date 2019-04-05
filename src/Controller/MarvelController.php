<?php
namespace App\Controller;

use App\ApiClient\MarvelApiHttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarvelController
{
    private $marvelApiHttpClient;

    public function __construct(
        MarvelApiHttpClient $marvelApiHttpClient
    ) {
        $this->marvelApiHttpClient = $marvelApiHttpClient;
    }

    /**
     * @Route("/characters")
     */
    public function characters(): Response
    {
        $characters = $this->marvelApiHttpClient->getCharacters();

        return $this->renderCharacters($characters);
    }

    /**
     * @Route("/characters-one-by-one")
     */
    public function charactersOneByOne(): Response
    {
        $characters = $this->marvelApiHttpClient->getCharactersOneByOne();

        return $this->renderCharacters($characters);
    }

    private function renderCharacters(array $characters = []): Response
    {
        $characterHtml = '';
        foreach ($characters as $character) {
            $characterHtml .= sprintf('<li>%s - %s</li>', $character['id'], $character['name']);
        }

        $html = sprintf('<html><body><ul>%s</ul></body></html>', $characterHtml);

        return new Response($html);
    }
}