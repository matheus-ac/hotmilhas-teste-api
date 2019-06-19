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
