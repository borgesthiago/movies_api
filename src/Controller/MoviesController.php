<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;


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

        $finder = new Finder();
        $finder->files()->in('/var/www/public/tmp/')->name($search.'.json');

        if ($finder->hasResults()) {
            //achou no cache

            //pegar o resultado e enviar como json para tela


            foreach ($finder as $file) {
                $conteudo = json_encode($file->getContents(), JSON_PRETTY_PRINT);
                dump(1);
            }
            return $this->json($conteudo);
        } else {

            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', 'http://www.omdbapi.com/?apikey=' . $key . '&s=' .$search,
                [
                    'headers'        => ['Accept-Encoding' => 'json'],
                    'decode_content' => false
                ]);

            $resDecode = json_decode($res->getBody()->getContents(), true);

            $filesystem = new Filesystem();
            $content = $this->json($resDecode);
            $filesystem->dumpFile('/var/www/public/tmp/' . $search . '.json', $content);

            return $this->json($resDecode);
        }
    }
}