<?php
namespace App\Controller;

use App\ApiClient\MarvelApiHttpClientScoped;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarvelScopedController
{
    private $marvelApiScopingHttpClient;

    public function __construct(
        MarvelApiHttpClientScoped $marvelApiScopingHttpClient
    ) {
        $this->marvelApiScopingHttpClient = $marvelApiScopingHttpClient;
    }

    /**
     * @Route("/scoped-characters")
     */
    public function characters(): Response
    {
        $characters = $this->marvelApiScopingHttpClient->getCharacters();

        return $this->renderCharacters($characters);
    }

    /**
     * @Route("/scoped-characters-one-by-one")
     */
    public function charactersOneByOne(): Response
    {
        $characters = $this->marvelApiScopingHttpClient->getCharactersOneByOne();

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