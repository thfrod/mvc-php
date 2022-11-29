<?php 

namespace App\Controller\Pages;
use \App\Utils\View;
class Page {
    
    // Responsável por retornar o cabeçalho
    private static function getHeader() {
        return View::render('pages/header');
    }
    // Responsável por retornar o rodapé

    private static function getFooter() {
        return View::render('pages/footer');
    }
    
    // Responsável por retornar o conteúdo (view) da nossa página genérica
    public static function getPage($title, $content) {
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter(),
        ]);

    }
}