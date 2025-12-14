<?php


namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class TmdbService
{
    private $client;
    private $apiKey;

    public function __construct(
        HttpClientInterface                  $client,
        #[Autowire('%tmdb_api_key%')] string $apiKey
    )
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getPopularMovies(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/popular',
            [
                'query' => [
                    'api_key' => $this->apiKey,
                    'language' => 'fr-FR', // Pour avoir les titres en français
                ],
            ]
        );

        // Convertit la réponse JSON en tableau PHP
        return $response->toArray();
    }
}
