<?php

namespace App\Controller\Admin;

use App\Model\Entity\User;
use App\Utils\View;
use App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page
{


    public static function getLogin($request, $errorMessage = null)
    {

        $status = !is_null($errorMessage) ? View::render('admin/login/status', [
            'message' => $errorMessage
        ]): '';
        $content = View::render('admin/login', [
            'status' => $status
        ]);
        return parent::getPage('Login', $content);
    }
    public static function setLogin($request)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['user_email'] ?? '';
        $password = $postVars['user_password'] ?? '';
        $obUser = User::getUserByEmail($email);
        
        if (!$obUser instanceof User || !password_verify($password, $obUser->user_password)) {
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }

        SessionAdminLogin::login($obUser);
        
        
    }
    public static function setLogout($request){
        SessionAdminLogin::logout();
        $request->getRouter()->redirect('/admin/login');
    }
}
