<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Http\Router;
use \App\Utils\View;

define('URL', 'http://localhost:8080');

View::init([
    'URL' => URL
]);

$Router = new Router(URL);

include __DIR__.'/routes/pages.php';

$Router->run()->sendResponse();