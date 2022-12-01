<?php

namespace App\Http;

class Request
{
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
    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $this->headers = getallheaders();
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
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
}
