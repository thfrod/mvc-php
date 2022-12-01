<?php

namespace App\Utils;

class View
{
    /**
     * Método responsável por retornar o conteúdo de uma view
     * @param string $view
     * @return string 
     */
    private static function getContentView($view)
    {
        $file = __DIR__ . '/../../resources/view/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }


    /**
     * Método responsável por retornar o conteúdo renderizado de uma view
     * @param string $view
     * @param array $vars (string/int)
     * @return string 
     */

    public static function render($view, $vars = [])
    {
        $contentView = self::getContentView($view);
        // União de variáveis da view
        $vars = array_merge(self::$vars, $vars);
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        return str_replace($keys, array_values($vars),$contentView);
    }
    // Variáveis padrões da view
    private static $vars = [];
    // Método responsável por definir os dados iniciais da classe
    public static function init($vars = []){
        self::$vars = $vars;
    }
}
