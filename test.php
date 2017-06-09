<?php

/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 5/18/17
 * Time: 10:11 AM
 */


if(!defined('VALID_DIR')) die("Can not be accessed directly");

class App
{

    const APP_PATH = '/';
    public static $_ROUTES = [
        'users' => [
            'view' => [
                'url' => '&do=view',
            ],
            'add' => [
                'url' => '&do=add',
            ],
            'delete' => [
                'url' => '&do=delete',
            ],
            'update' => [
                'url' => '&do=update',
            ],
        ],
        'mates' => [
            'view' => [
                'url' => '&do=view',
                'view' => 'test/view/view.php',
            ],
            'add' => [
                'url' => '&do=add',
                'view' => 'test/view/add.php',
            ],
            'delete' => [
                'url' => '&do=delete',
            ],
            'update' => [
                'url' => '&do=update',
                'view' => 'test/view/update.php'
            ],
        ]
    ];

    public function _route($route, $params = null)
    {


        $route = explode(".", $route);
        $r = "";
        $r .= "?module=" . $route[0];
        if (count($route) >= 1) {
            $r .= "&view=" . $route[1];
        }
        if (count($route) >= 2) {
            $r .= self::$_ROUTES[$route[1]][$route[2]]['url'];
        }
        if ($params != null) {
            foreach ($params as $key => $param) {
                $r .= "&{$key}={$param}";
            }
        }

        return $r;

    }

    public static function _view($route, $params = null)
    {

        $route = explode(".", $route);
        $r = "";

        if (count($route) >= 2) {
            $r = self::$_ROUTES[$route[1]][$route[2]]['view'];
        }

        $file = dirname ( __FILE__ ).self::APP_PATH.$r;
        extract($params);
        include "{$file}";
    }
}

class User {

    public $name;
    public $surname;
    public $email;
    public $task;

    function __construct()
    {
        $this->name = "TEst";
        $this->surname = "Test Filani";
        $this->email = "Email";
        $this->task = new Task();
    }

    public function getFullName($ext = "")
    {
        return $ext.$this->name.' '.$this->surname;
    }

    public function getTask()
    {
        return $this->task;
    }

}

class Task {

    public $title;
    public $priority;

    function __construct()
    {
        $this->title = "Todo";
        $this->priority = "Easy";
    }

    public function getTaskDetials()
    {
        return "Title: {$this->title} has {$this->priority} priority ";
    }
}

$singleUser = new User();

App::_view("matesa.mates.update", ['singleUser' => $singleUser, 'd' => 3, 'fdsfds' => 'fdsfsf']);