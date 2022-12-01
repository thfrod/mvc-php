<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;
// Responsável por retornar o conteúdo (view) da nossa página de sobre
class About extends Page
{
    public static function getAbout()
    {
        $obOrganization = new Organization;
        // View da home
        $content =  View::render('pages/about', [
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site' => $obOrganization->site,
        ]);
        // View da página
        return parent::getPage('Sobre', $content);
    }
}
