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

}
