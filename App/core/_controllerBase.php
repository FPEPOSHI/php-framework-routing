<?php

/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 7/31/17
 * Time: 10:01 AM
 */
class _controllerBase
{

    function __construct()
    {

        if (!App::isLogged()) {
            App::redirect('loginController');
        }

    }
}