<?php

namespace App\Http;

class Request
{
    // Instância do router
    // @var Router
    private $router;

    // Método HTTP da requisição 
    // @var string
    private $httpMethod;

    // URI dá página 
    // @var string
    private $uri;

    // Váriaveis recebidas no POST da página ($_POST)
    // @var array
    private $queryParams = [];

    // Cabeçalho da requisição
    // @var array
    private $postVars = [];


    // Cabeçalho da requisição
    // @var array
    private $headers = [];

    // Construtor da classe
    public function __construct($router)
    {
        $this->router = $router;
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        $this->headers = getallheaders();
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
    }
    
    private function setUri()
    {
        // URI completa (com gets)
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        //Remove GETS da URI
        $xUri = explode('?', $this->uri);
        
        $this->uri = $xUri[0];
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getPostVars()
    {
        return $this->postVars;
    }

    public function getRouter()
    {
        return $this->router;
    }
}
