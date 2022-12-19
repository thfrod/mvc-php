<?php

namespace App\Http;

use \Closure;
use Exception;
use ReflectionFunction;
use \App\Http\Middleware\Queue as MiddlewareQueue;

class Router
{
    // URL Completa do projeto (raíz)
    // @var string
    private $url = '';

    // Prefixo de todas as rotas
    // @var string
    private $prefix = '';

    // Índice de rotas
    // @var array
    private $Http = [];

    // Instância de request
    // @var Request
    private $request;

    // Construtor
    // @param string $url
    public function __construct($url)
    {
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    // Método responsável por definir o prefixo das rotas
    private function setPrefix()
    {
        $parseURL = parse_url($this->url);
        $this->prefix = $parseURL['path'] ?? '';
    }


    //Método responsável por adicionar uma rota na classe 
    // @param string $method
    // @param string $route
    // @param array  $params
    private function addRoute($method, $route, $params)
    {
        //Validação dos parâmetros
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $params['middlewares'] = $params['middlewares'] ?? [];

        // Variáveis da rota
        $params['variables'] = [];

        // Padrão de validação das variáveis das rotas 
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //Padrão de validação da URL
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        //Adiciona rota dentro da classe
        $this->Http[$patternRoute][$method] = $params;
    }


    //Método responsável por definir  uma rota de GET 
    // @param string $route
    // @param array  $params
    public function get($route, $params)
    {
        return $this->addRoute('GET', $route, $params);
    }

    //Método responsável por definir  uma rota de POST 
    // @param string $route
    // @param array  $params
    public function post($route, $params)
    {
        return $this->addRoute('POST', $route, $params);
    }

    //Método responsável por definir  uma rota de PUT 
    // @param string $route
    // @param array  $params
    public function put($route, $params)
    {
        return $this->addRoute('PUT', $route, $params);
    }

    //Método responsável por definir  uma rota de DELETE 
    // @param string $route
    // @param array  $params
    public function delete($route, $params)
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    //Método responsável por retornar URI sem prefixo
    // @var string
    private function getUri()
    {
        //URI da request
        $uri = $this->request->getUri();
        // Fatia a URI com prefixo
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        return end($xUri);
    }

    //Método responsável por retornar os dados da rota atual 
    // @return array
    private function getRoute()
    {
        //URI
        $uri = $this->getUri();

        //Método
        $httpMethod = $this->request->getHttpMethod();

        // Valida as rotas
        foreach ($this->Http as $patternRoute => $methods) {
            // Verifica se a rota bate com o padrão
            if (preg_match($patternRoute, $uri, $matches)) {
                //Verifica o método 
                if (isset($methods[$httpMethod])) {

                    unset($matches[0]);

                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    return $methods[$httpMethod];
                }
                throw new Exception('Método não permitido', 405);
            }
        }
        throw new Exception('URL não encontrada', 404);
    }

    //Método responsável por executar a rota atual 
    // @return Response
    public function run()
    {
        try {
            $route = $this->getRoute();

            // Verifica o controlador
            if (!isset($route['controller'])) {
                throw new Exception('URL não pode ser processada, conta-te o administrador do sistema', 500);
            }
            // Argumentos da função
            $args = [];

            //Reflection 
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            };
           
            return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    public function getCurrentUrl()
    {
        return $this->url . $this->getUri();
    }
}
