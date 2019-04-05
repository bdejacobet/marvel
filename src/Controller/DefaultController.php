<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        return new Response('<html><body><ul>Pour jouer avec l\'api marvel et symfony/httpClient</ul></body></html>');
    }
}