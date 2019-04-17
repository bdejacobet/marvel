<?php
namespace App\ApiClient;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Component\HttpFoundation\Response;

class GitlabApiHttpClientScoped
{
    /**
     * HttpClient
     */
    private $httpClient;

    public function __construct(string $gitlabToken)
    {
        $client = HttpClient::create();

        $this->httpClient = new ScopingHttpClient($client, [
            'https://gitlab\.ekino\.com/' => [
                'base_uri' => 'https://gitlab.ekino.com',
                'headers'  => ['Private-Token: '.$gitlabToken],
            ],
        ], 'https://gitlab\.ekino\.com/');
    }

    public function getProjects(): array
    {
        $response = $this->httpClient->request('GET', '/api/v4/projects');

        return $response->toArray();
    }

    public function getProject($id): array
    {
        $response = $this->httpClient->request('GET', sprintf('/api/v4/projects/%d', $id));

        return $response->toArray();
    }

    public function getProjectMembers($id): array
    {
        $response = $this->httpClient->request('GET', sprintf('/api/v4/projects/%d/members', $id));

        return $response->toArray();
    }
}