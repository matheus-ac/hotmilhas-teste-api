<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class ApiController extends Controller
{
    public function getMarcas($id)
    {
        $json = file_get_contents('https://www.seminovosbh.com.br/marcas/buscamarca/tipo/'.$id.'/data.js');
        $url = json_decode($json);

        return $url;
    }

    public function getModelos($id)
    {
        $json = file_get_contents('https://www.seminovosbh.com.br/json/modelos/buscamodelo/marca/'.$id.'/data.js');
        $url = json_decode($json);

        return $url;
    }

    public function getCidades(Request $request)
    {
        $veiculo = $request->veiculo;
        $marca = $request->marca;
        $modelo = $request->modelo;


        $json = file_get_contents('https://www.seminovosbh.com.br/json/index/busca-cidades/veiculo/'.$veiculo.'/marca/'.$marca.'/modelo/'.$modelo.'/cidade/0/data.js');
        $url = json_decode($json);
        return $url;
    }

    public function getSearch(Request $request)
    {
        $veiculo = $request->veiculo;
        $marca = $request->marca;
        $modelo = $request->modelo;
        $cidade = $request->cidade;

        $url = 'https://www.seminovosbh.com.br/resultadobusca/index/veiculo/'.$veiculo.'/marca/'.$marca.'/modelo/'.$modelo.'/cidade/'.$cidade.'/usuario/todos';


        $client = new Client();
        $result =[];

        $crawler = $client->request('GET', $url);
        $pages = ($crawler->filter('.paginacao a')->count() > 0)
            ? $crawler->filter('.total')->text()
            : 0;

        for ($i = 1; $i <= $pages; $i++) {
            if ($i != 0) {

                $crawler = $client->request('GET', $url. '/pagina/' . $i);
            }

            $crawler->filter('.bg-busca')->each(function ($node) use (&$result) {
                $url_anuncio = $node->filter('.titulo-busca a')->link()->getUri();
                $url_anuncio = (explode("/", $url_anuncio));
                $id = $url_anuncio[7];

                $titulo = explode(" R$", $node->filter('.titulo-busca h4')->text());

                $result[] = [
                    'titulo'        => $titulo[0],
                    'valor'         => trim($node->filter('.preco_busca')->text()),
                    'ano'           => $node->filter('dd > p')->first()->text(),
                    'km'            => trim($node->filter('dd > p')->eq(1)->text()),
                    'detalhes'         => url('/api/detalhes/'.$id),
                    'img'           => $node->filter('img')->attr('src'),
                    ];
            });
        }

        return json_encode($result, JSON_FORCE_OBJECT);

    }
}
