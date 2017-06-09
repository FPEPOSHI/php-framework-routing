<?php
/**
 * Created by PhpStorm.
 * User: fpeposhi
 * Date: 5/18/17
 * Time: 1:27 PM
 */


class usersController
{

    public $user;
    function __construct()
    {
        $this->user = "21312";
    }

    public function add( )
    {
        $singleUser = new User();
        App::_view('users.view.addUser', ['singleUser' => $singleUser, 'd' => 3, 'fdsfds' => 'fdsfsf']);
    }

    public function view()
    {
        $singleUser = new User();
        App::_view('users.view.viewUser', ['singleUser' => $singleUser, 'd' => 3, 'fdsfds' => 'fdsfsf']);
    }


}