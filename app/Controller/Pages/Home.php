<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;
// Responsável por retornar o conteúdo (view) da nossa home
class Home extends Page
{
    public static function getHome()
    {
        $obOrganization = new Organization;
        // View da home
        $content =  View::render('pages/home', [
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site' => $obOrganization->site,
        ]);
        // View da página
        return parent::getPage('Thfrod', $content);
    }
}
