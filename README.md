Teste PHP Web Scraper - Hotmilhas
================================

Requirements
------------
Configure um certificado válido. 
Baixe-o neste link: https://curl.haxx.se/docs/caextract.html

E no seu php.ini, configure:

curl.cainfo = "C:\caminho\para\o\certificado\cacert.pem"

Installation
------------

Renomear .env.example para .env

.. code-block:: bash

    composer install

Uso
-----
* Lista marcas:
    * GET http://localhost:8000/api/getmarcas/id
        * ID é o tipo do veiculo 
            * 1 = carro
            * 2 = caminhão
            * 3 = moto

* Lista modelos:
    * GET http://localhost:8000/api/getmodelos/id
        * ID é a marca do veiculo, utilize o getmarcas acima para receber o ID da marca

* Lista modelos:
    * POST http://localhost:8000/api/getcidades
        * Informe os valores na requisão -> veiculo, marca, modelo
        * Exemplo: http://prntscr.com/o42bk8

* Lista pesquisa:
    * POST http://localhost:8000/api/getsearch
        * Informe os valores na requisão -> veiculo, marca, modelo, cidade
        * Exemplo: http://prntscr.com/o42cju

* Exibir detalhes de um anuncio:
    * GET http://localhost:8000/api/detalhes/id
        * ID é do anuncio, utilize o getsearch acima para receber o ID do anuncio
        * Exemplo: http://prntscr.com/o42e1u
