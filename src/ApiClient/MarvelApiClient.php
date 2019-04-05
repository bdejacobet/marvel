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

        $response = $this->client->request('GET', $url, $options);

        return $response->toArray()['data']['results'];
    }

    public function getCharactersOneByOne(): array
    {
        $return = $responses= [];

        $options = [
            'query' => [
                'ts'     => $this->ts,
                'apikey' => $this->apiPublicKey,
                'hash'   => $this->hash,
            ]
        ];

        foreach ([1011334, 1009144, 1010699] as $characterId) {
            $url         = sprintf('https://gateway.marvel.com/v1/public/characters/%d', $characterId);
            $responses[] = $this->client->request('GET', $url, $options);
        }

        foreach ($responses as $response) {
            $return[] = $response->toArray()['data']['results'][0];
        }

        return $return;
    }
}