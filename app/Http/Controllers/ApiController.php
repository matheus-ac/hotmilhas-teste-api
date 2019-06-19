<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Goutte\Client;
use Illuminate\Http\Request;

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
                    'anuncio_id'    => $id,
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

    public function getDetalhes($id)
    {

        $client = new Client();
        $crawler = $client->request('GET', 'https://www.seminovosbh.com.br/veiculo/codigo/'.$id);

        $result['id'] = $id;
        $result['titulo'] = $crawler->filter('#textoBoxVeiculo h5')->text();
        $result['valor'] = $crawler->filter('#textoBoxVeiculo p')->text();
        $result['fotoVeiculo'] = $crawler->filter('#fotoVeiculo img')->attr('src');


        $crawler->filter('#infDetalhes')->each(function ($node) use (&$result) {
            $total = $node->filter('ul > li')->count();
            for ($i = 0; $i < $total; $i++) {
                $li[] = $node->filter('ul li')->eq($i)->text();
            };
            $result['Detalhes'] = $li;
        });
        $crawler->filter('#infDetalhes2')->each(function ($node) use (&$result) {
            $total = $node->filter('ul > li')->count();
            for ($i = 0; $i < $total; $i++) {
                $li[] = $node->filter('ul li')->eq($i)->text();
            };
            $result['Acessórios'] = $li;
        });
        $crawler->filter('#infDetalhes3')->each(function ($node) use (&$result) {
            $total = $node->filter('ul > p')->count();
            for ($i = 0; $i < $total; $i++) {
                $p[] = $node->filter('ul p')->eq($i)->text();
            };
            $result['Observações'] = $p;
        });
        $crawler->filter('#infDetalhes4')->each(function ($node) use (&$result) {
            $total = $node->filter('ul > li')->count();
            for ($i = 0; $i < $total; $i++) {
                $li[] = trim($node->filter('ul li')->eq($i)->text());
            };
            $result['Contato'] = $li;
        });

        return json_encode($result, JSON_FORCE_OBJECT);

    }
}
