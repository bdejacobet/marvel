<?php
namespace App\Controller;

use App\ApiClient\MarvelApiHttpClientScoped;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarvelScopedController extends AbstractController
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

        return $this->render('characters.html.twig', ['characters' => $characters]);
    }

    /**
     * @Route("/scoped-characters-one-by-one")
     */
    public function charactersOneByOne(): Response
    {
        $characters = $this->marvelApiScopingHttpClient->getCharactersOneByOne();

        return $this->render('characters.html.twig', ['characters' => $characters]);
    }
}