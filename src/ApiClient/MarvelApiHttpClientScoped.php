<?php
namespace App\ApiClient;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Component\HttpFoundation\Response;

class MarvelApiHttpClientScoped
{
    /**
     * HttpClient
     */
    private $httpClient;

    public function __construct(
        string $apiPublicKey,
        string $apiPrivateKey
    ) {
        $client = HttpClient::create();
        $ts     = '1';
        $hash   = md5(sprintf('%s%s%s', $ts, $apiPrivateKey, $apiPublicKey));

        $this->httpClient = new ScopingHttpClient($client, [
            'https://gateway\.marvel\.com/v1/public/' => [
                'base_uri' => 'https://gateway.marvel.com/v1/public/',
                'query'    => [
                    'ts'     => $ts,
                    'apikey' => $apiPublicKey,
                    'hash'   => $hash,
                ]
            ],
        ], 'https://gateway\.marvel\.com/v1/public/');
    }

    public function getCharacters(): array
    {
        $response = $this->httpClient->request('GET', 'https://gateway.marvel.com/v1/public/characters');

        return $response->toArray()['data']['results'];
    }

    public function getCharactersOneByOne(): array
    {
        $characterIds = [1011334, 1009144, 1, 1010699];
        $characters = $responses = [];

        // Concurrent request
        foreach ($characterIds as $characterId) {
            $url = sprintf('https://gateway.marvel.com/v1/public/characters/%d', $characterId);
            $responses[] = $this->httpClient->request('GET', $url);
        }

        // Without exception
        foreach ($responses as $response) {
            if (Response::HTTP_OK === $response->getStatusCode()) {
                $characters[] = $response->toArray()['data']['results'][0];
            }
        }

        return $characters;
    }
}