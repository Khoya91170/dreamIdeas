<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 21/06/2015
 * Time: 02:44
 */

namespace Application\Model;
use Zend\Session\Container;

class SessionManager
{
    private static function getContainer()
    {
        return new Container('user');
    }

    public static function sessionExists()
    {
        return SessionManager::getContainer()->offsetExists('login');
    }

    public static function getLogin()
    {
        $container = SessionManager::getContainer();
        return $container->offsetExists('login') ? $container->offsetGet('login') : null;
    }

    public static function getIdUser()
    {
        $container = SessionManager::getContainer();
        return $container->offsetExists('id') ? $container->offsetGet('id') : null;
    }

    public static function setLogin($login)
    {
        SessionManager::getContainer()->login = $login;
    }

    public static function setIdUser($id)
    {
        SessionManager::getContainer()->id = $id;
    }

    public static function destroy()
    {
        SessionManager::getContainer()->getManager()->destroy();
    }
}