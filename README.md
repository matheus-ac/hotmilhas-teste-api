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

