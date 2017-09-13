<?php

/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 7/31/17
 * Time: 10:01 AM
 */
class _controllerBase
{

    function __construct($use_login = true)
    {

        if ($use_login && !App::isLogged()) {
            App::redirect('loginController');
        }

    }
}