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
}
