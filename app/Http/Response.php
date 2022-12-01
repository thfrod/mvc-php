<?php

namespace App\Http;

class Response
{
    // Código de status HTTP
    // @var integer
    private $httpCode = 200;

    // Cabeçalho do Response
    // @var array
    private $headers = [];

    // Tipo de conteúdo que está sendo retornado
    // @var string
    private $contentType = 'text/html';

    // Conteúdo do Response
    // @var mixed
    private $content;
    // método responsável por iniciar a classe e definir os valores  
    // @param integer $httpCode
    // @param mixed  $content
    // @param string $contentType
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    // Método responsável por alterar o content type da response
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    // Método responsável por adicionar um registro no  cabeçalho da response
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    // Método responsável por enviar resposta para o usuário
    public function sendResponse()
    {
        $this->sendHeaders();
        // Imprime conteúdo
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }

    // Método responsável por enviar resposta para o usuário
    private function sendHeaders()
    {
        // STATUS
        http_response_code($this->httpCode);
        // Enviar headers
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }
}
