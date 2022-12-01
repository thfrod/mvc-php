<?php

use \App\Http\Response;
use \App\Controller\Pages;

// Rota da Home
$Router->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

$Router->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);
// Rota dinâmica
$Router->get('/pagina/{idPage}/{action}', [
    function ($idPage, $action) {
        return new Response(200, 'Página ' . $idPage . ' - ' . $action);
    }
]);
