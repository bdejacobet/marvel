<?php
namespace App\Controller;

use App\ApiClient\MarvelApiHttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MarvelController extends AbstractController
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

        return $this->render('characters.html.twig', ['characters' => $characters]);
    }

    /**
     * @Route("/characters-one-by-one")
     */
    public function charactersOneByOne(): Response
    {
        $characters = $this->marvelApiHttpClient->getCharactersOneByOne();

        return $this->render('characters.html.twig', ['characters' => $characters]);
    }
}