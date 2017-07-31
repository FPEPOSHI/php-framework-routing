<?php

/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 7/31/17
 * Time: 10:01 AM
 */
class usersController extends _controllerBase
{

    public function login($id)
    {
        $this->db = null;



        App::_view('login.view',['a'=>1232]);
    }

}