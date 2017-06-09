<?php

/**
 * Created by PhpStorm.
 * User: fpeposhi
 * Date: 5/18/17
 * Time: 10:11 AM
 */


if (!defined('VALID_DIR')) die("Can not be accessed directly");

class Route
{


    public static function get($module, $controller, $function)
    {

        return [
            "{$module}.{$controller}.{$function}" => [
                'module' => $module,
                'function' =>$function,
                'controller' =>$controller,
                'controller_url' => App::APP_PATH."{$module}/controller/{$controller}.php",
                'url' => "?module={$module}&view={$controller}&do={$function}"
        ]];

    }

}

class App
{

    const APP_PATH = '/App/modules/';
    const APP_DOMAIN = 'www.example.io';

    public static function _ROUTES()
    {
        $route = [];

        $route = array_merge($route, Route::get("users","usersController","add"));
        $route = array_merge($route, Route::get("users","usersController","delete"));
        $route = array_merge($route, Route::get("users","usersController","view"));
        $route = array_merge($route, Route::get("users","usersController","view"));

        $route = array_merge($route, Route::get("abonent","abonentController","view"));

        return $route;
    }

    public static function _route($_route, $params = null)
    {
        $route = self::_ROUTES();
        $url = $route[$_route]['url'];
        if ($params != null) {
            foreach ($params as $key => $param) {
                $url .= "&{$key}={$param}";
            }
        }
        return self::APP_DOMAIN."/{$url}";
    }

    public static function _view($view, $params = null)
    {
        $file = str_replace(".",'/', $view);
        $file = dirname(__FILE__) . self::APP_PATH . $file.'.php';
        extract($params);
        include "{$file}";
    }
    public static function _controller($params)
    {

        if(count($params) < 3)
        {
            return false;
        }

        $routes = self::_ROUTES();
        $route = array_slice($params,0,3);
        $route = array_values($route);
        $route = implode(".",$route);
        if(!isset($routes[$route]))
            return false;
        $route = $routes[$route];

        $_params = count($params) > 3 ? array_slice($params,3) : [];
        $route = array_merge($route, [
            'params' => $_params
        ]);

        return $route;

    }
}

class User
{

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
        return $ext . $this->name . ' ' . $this->surname;
    }

    public function getTask()
    {
        return $this->task;
    }

}

class Task
{

    public $title;
    public $priority;

    function __construct()
    {
        $this->title = "Todo";
        $this->priority = "Easy";
    }

    public function getTaskDetials()
    {
        return "Task with title <b> {$this->title}</b> has <i>{$this->priority}</i> priority ";
    }
}
$singleUser = new User();



//echo json_encode(App::_ROUTES());die();
//App::_view('users.view.addUser', ['singleUser' => $singleUser, 'd' => 3, 'fdsfds' => 'fdsfsf']);


//App::_view("matesa.mates.update", ['singleUser' => $singleUser, 'd' => 3, 'fdsfds' => 'fdsfsf']);
//App::_view("matesa.mates.update", ['singleUser' => $singleUser, 'd' => 3, 'fdsfds' => 'fdsfsf']);



?>


<?//=  App::_route('users.usersController.add', ['d' => 3, 'fdsfds' => 'fdsfsf']); ?>
<?//=  json_encode(App::_controller(['module' => "users", 'view' => 'usersController','do' => 'add','id'=>1,"fds"=>'fdsf'])); ?>
