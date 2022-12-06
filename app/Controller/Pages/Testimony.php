<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    // Método responsável por obter a renderização dos itens de depoimentos para a página
    private static function getTestimonytens($request, &$obPagination)
    {
        $itens = '';

        // Quantidade total de registros
        $totalQuantity = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
        $queryParams = $request->getQueryParams();
        $actualPage = $queryParams['page'] ?? '1';

        // Instância da paginação
        $obPagination = new Pagination($totalQuantity, $actualPage, 5);


        $results = EntityTestimony::getTestimonies(null, 'testimony_id DESC', $obPagination->getLimit());

        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('pages/testimony/item', [
                'name' => $obTestimony->testimony_name,
                'message' => $obTestimony->testimony_message,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimony->testimony_data))
            ]);
        }
        return $itens;
    }

    public static function getTestimonies($request)
    {
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonytens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);
        return parent::getPage('DEPOIMENTOS', $content);
    }

    public static function insertTestimony($request)
    {
        // Dados do POST
        $postVars = $request->getPostVars();

        $obTestimony = new EntityTestimony;
        $obTestimony->name = $postVars['name'];
        $obTestimony->message = $postVars['message'];
        $obTestimony->register();

        return self::getTestimonies($request);
    }
}
