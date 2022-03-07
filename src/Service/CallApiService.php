<?php 
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{

    
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getFranceData($postcode): array
    {
        $response = $this->client->request(
            'GET',
            "https://api-adresse.data.gouv.fr/search/?q=". $postcode . "&limit=1"           
        );
        
        return $response->toArray();
    }
}