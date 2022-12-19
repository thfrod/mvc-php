<?php

namespace App\Http\Middleware;

use Exception;

class Maintenance
{

    public function handle($request, $next)
    {
        if (getenv('MAINTENANCE') == 'true') {
            throw new \Exception('Página em manutenção, tente novamente mais tarde.', 200);
        }
        return $next($request);
    }
}
