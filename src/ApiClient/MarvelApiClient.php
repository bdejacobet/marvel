<?php
namespace App\ApiClient;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\HttpClient\HttpClient;

class MarvelApiClient
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
        $this->client        = HttpClient::create();
        $this->ts            = '1';
        $this->hash          = md5(sprintf('%s%s%s', $this->ts, $this->apiPrivateKey, $this->apiPublicKey));
    }

    public function getCharacters(): ResponseInterface
    {
        $url = 'https://gateway.marvel.com/v1/public/characters';

        $options = [
            'query' => [
                'ts'     => $this->ts,
                'apikey' => $this->apiPublicKey,
                'hash'   => $this->hash,
            ]
        ];

        $response = $this->client->request('GET', $url, $options);

        return $response;
    }
}