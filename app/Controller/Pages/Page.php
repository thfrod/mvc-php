<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page
{

    // Responsável por retornar o cabeçalho
    private static function getHeader()
    {
        return View::render('pages/header');
    }
    // Responsável por retornar o rodapé

    private static function getFooter()
    {
        return View::render('pages/footer');
    }

    // Responsável por retornar o conteúdo (view) da nossa página genérica
    public static function getPage($title, $content)
    {
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter(),
        ]);
    }
    public static function getPagination($request, $obPagination)
    {
        $pages = $obPagination->getPages();
        if (count($pages) <= 1) return '';
        $links = '';
        
        $url = $request->getRouter()->getCurrentUrl();

        $queryParams = $request->getQueryParams();

        // echo '<pre>';
        // print_r($url);
        // echo '</pre>';
        // exit;
        foreach($pages as $page){
            $queryParams['page'] = $page['page'];
            $link = $url.'?'.http_build_query($queryParams);
            
            $links .=  View::render('pages/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
            

        }
        // echo '<pre>';
        // print_r($link);
        // echo '</pre>';
        // exit;
        return View::render('pages/pagination/box', [
            'links' => $links,
            
        ]);
    }
}
