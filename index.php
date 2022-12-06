<?php
require __DIR__.'/includes/app.php';

use \App\Http\Router;

$Router = new Router(URL);

include __DIR__.'/routes/pages.php';

$Router->run()->sendResponse();
