<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request)
    {
        $key = $_ENV['API_KEY'];
        $search = $request->get('s');

        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', 'http://www.omdbapi.com/?apikey=' . $key . '/?s=' .$search, [
            'headers' => [
                'User-Agent' => 'testing/1.0',
                'Accept' => 'application/json',
            ]
        ]);

        $resDecode = json_decode($res->getBody()->getContents());

        return $this->json([$resDecode]);
    }
}