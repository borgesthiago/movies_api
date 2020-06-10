<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp;


class MoviesController extends AbstractController
    /**
     * @Route("/movies", name="movies_")
     */
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $key = $_ENV['API_KEY'];
        $title = 'comedy';

        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', 'http://www.omdbapi.com/?apikey=' . $key . '&t=' .$title, [
            'headers' => [
                'User-Agent' => 'testing/1.0',
                'Accept' => 'application/json',
            ]
        ]);

        return $this->json([
            'data' => $res
        ]);

    }

}