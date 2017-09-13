<?php

/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 7/31/17
 * Time: 10:38 AM
 */
class loginController
{
    function __construct()
    {

        if (App::isLogged()) {
            App::redirect('homeController');
        } else if (isset($_POST['Logme'])) {
            $this->checkLogin();
        } else {
            App::_view('login.view');
        }
    }


    public function checkLogin()
    {

        echo 'U therrit funksioni';

    }

}