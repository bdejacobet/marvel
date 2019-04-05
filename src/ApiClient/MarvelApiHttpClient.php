<?php
namespace App\ApiClient;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\HttpClient\HttpClient;

class MarvelApiHttpClient
{
    /**
     * HttpClient
     */    
    private $httpClient;

    /**
     * string
     */    
    private $apiPublicKey;

    /**
     * string
     */    
    private $apiPrivateKey;

    /**
     * string
     */    
    private $hash;

    /**
     * int
     */    
    private $ts;

    public function __construct(
        string $apiPublicKey,
        string $apiPrivateKey
    ) {
        $this->apiPublicKey  = $apiPublicKey;
        $this->apiPrivateKey = $apiPrivateKey;
        $this->httpClient    = HttpClient::create();
        $this->ts            = '1';
        $this->hash          = md5(sprintf('%s%s%s', $this->ts, $this->apiPrivateKey, $this->apiPublicKey));
    }

    public function getCharacters(): array
    {
        $url = 'https://gateway.marvel.com/v1/public/characters';

        $options = [
            'query' => [
                'ts'     => $this->ts,
                'apikey' => $this->apiPublicKey,
                'hash'   => $this->hash,
            ]
        ];

        $response = $this->httpClient->request('GET', $url, $options);

        return $response->toArray()['data']['results'];
    }

    public function getCharactersOneByOne(): array
    {
        $characterIds = [1011334, 1009144, 1, 1010699];
        $characters = $responses = [];

        $options = [
            'query' => [
                'ts'     => $this->ts,
                'apikey' => $this->apiPublicKey,
                'hash'   => $this->hash,
            ]
        ];

        // Concurrent request
        foreach ($characterIds as $characterId) {
            $url = sprintf('https://gateway.marvel.com/v1/public/characters/%d', $characterId);
            $responses[] = $this->httpClient->request('GET', $url, $options);
        }

        // Without exception
        foreach ($responses as $response) {
            if (Response::HTTP_OK === $response->getStatusCode()) {
                $characters[] = $response->toArray()['data']['results'][0];
            }
        }

        // With exception
//        foreach ($responses as $response) {
//            try {
//                $response->getHeaders(true);
//                $characters[] = $response->toArray()['data']['results'][0];
//            } catch (ClientException $e) {
//                dump($e);
//            }
//        }

        return $characters;
    }
}