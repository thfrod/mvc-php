<?php

use \App\Http\Response;
use \App\Controller\Admin;


$Router->get('/admin', [
    'middlewares' => [
        'required-admin-login'
    ],

    function () {
        return new Response(200, 'Admin :)');
    }
]);

$Router->get('/admin/login', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

$Router->post('/admin/login', [
    'middlewares' => [
        'required-admin-logout'
    ],

    function ($request) {
        
        return new Response(200, Admin\Login::setLogin($request));
    }
]);

$Router->get('/admin/logout', [
    'middlewares' => [
        'required-admin-login'
    ],

    function ($request) {
        return new Response(200, Admin\Login::setLogout($request));
    }
]);
