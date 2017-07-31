<?php

/**
 * Created by PhpStorm.
 * User: fpeposhi
 * Date: 5/18/17
 * Time: 10:11 AM
 */


if (!defined('VALID_DIR')) die("Can not be accessed directly");
session_start();

class Route
{


    public static function get( $controller, $function,$module = '')
    {

        return [
                'function' =>$function,
                'controller' =>$controller,
                'controller_path' => App::APP_PATH."/controllers/{$controller}.php",
                'url' => "?{$controller}/{$function}"
            ];

    }

}

class App
{

    const APP_PATH = '/App';
    const APP_DOMAIN = '/rocketFramework';
    const APP_URLDOMAIN = 'localhost/rocketFramework';
    const APP_DOMAIN_AJAX = '/localhost/ajax.php';
    const ADMIN_URL = "/admin.php";
    const TITLE = "rocket Framework";
    const TICKET_SERIAL = 100000;


    /*
     * @deprecated
     * */
    public static function _ROUTES()
    {
        $route = [];

        return $route;
    }


    public static function core(){

        include_once "_controllerBase.php";
        include_once "_dbModel.php";
        include_once "_baseModel.php";
    }

    public static function main(){

        App::core();


        if (strtolower(filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest') {
            // I'm AJAX!
            ob_start();
        }

        set_error_handler(function($errno, $errstr, $errfile, $errline ){
            throw new ErrorException($errstr, $errno, 1, $errfile, $errline);
        });

        $controller = App::_controller($_GET);

        if ($controller != false) {
            include_once self::getRealPath(). "{$controller['controller_path']}";
            $class = $controller['controller'];

            if(class_exists($class)) {

                $obj = new $class();

                if ($controller['function'] != '' && method_exists($obj, $controller['function'])) {
                    try {

                        call_user_func_array(array($obj, $controller['function']), $controller['params']);

                    } catch (ErrorException $e) {
                        if ($e->getCode() == 2) {//Missing argumets
                            echo "Funksioni '{$controller['function']}' kerkon parametra! [1]";
                        } else {
                            echo $e->getCode();
                        }
                    }

                } else if($controller['function'] == ''){
                    //called constructor
                } else {
                    echo "Funksioni {$controller['function']} nuk ekziston :P [2]";

                }
            }else{
                echo "Kontrolleri {$controller['controller']} nuk ekziston :P [3]";
            }
        }else{
            if (strtolower(filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest') {
                // I'm AJAX!

            }else{
                include  self::getRealPath()."welcome.php";
            }
        }

        if (strtolower(filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest') {
            // I'm AJAX!
            ob_end_flush();
        }


    }

    public static function _route($_route, $params = null)
    {

        $_route = explode('.',$_route);


        $controller = isset($_route[0]) ? $_route[0] : false;
        $function = isset($_route[1]) ? $_route[1] : false;

        if(!$controller){
            return App::home();
        }

        if(!$function){
            $function = '';
        }else{
            $function = "/{$function}";
        }

        $url = "?{$controller}{$function}";

        if ($params != null) {
            foreach ($params as $key => $param) {
                $url .= "/{$param}";
            }
        }
        return self::APP_DOMAIN."/{$url}";
    }

    public static function _ajax($_route, $params = null)
    {
        $route = self::_ROUTES();
        $url = $route[$_route]['url'];
        if ($params != null) {
            foreach ($params as $key => $param) {
                $url .= "&{$key}={$param}";
            }
        }
        return self::APP_DOMAIN_AJAX."{$url}";
    }

    public static function _model($model)
    {
        $file = str_replace(".",'/', $model);
        $file = App::getRealPath(). self::APP_PATH.'/models/' . $file.'.php';
        include_once "{$file}";
    }

    public static function _view($view, $params = null)
    {
        $file = str_replace(".",'/', $view);
        $file = App::getRealPath(). self::APP_PATH.'/views/' . $file.'.php';
        if($params) {
            extract($params);
        }
        include "{$file}";
    }

    public static function _render($view, $params = null)
    {
        $file = str_replace(".",'/', $view);
        $file = dirname(__FILE__) . self::APP_PATH . $file.'.php';
        if($params) {
            extract($params);
        }

        ob_start();
        include "{$file}";
        return ob_get_clean();
    }





    public static function need_params($func) {
        $reflection = new ReflectionFunction($func);

        return $reflection->getNumberOfParameters();
    }

    public static function _controller($params)
    {
        $params = array_keys($params);

        $params = explode('/',$params[0]);

        $controller = isset($params[0]) ? $params[0] : false;
        $function = isset($params[1]) ? $params[1] : false;

        if(!$controller){
            return false;
        }
        if(!$function){
            $function = '';
        }

        $route = Route::get($controller, $function);
        $_params = count($params) > 2 ? array_slice($params,2) : [];
        $route = array_merge($route, [
            'params' => $_params
        ]);

        return $route;

    }


    private static  function getRealPath(){
       return  realpath(__DIR__ . '/../..');
    }


    public static function _resource($resource)
    {
        $file = dirname(__FILE__) . self::APP_PATH_RESOURCES . $resource;
        include "{$file}";
    }

    public static function redirect($url)
    {
        header("Location: {$url}");
    }


    public static function isAdmin()
    {
        return $_SESSION['USERTYPE'] == 1;
    }
    public static function getRole()
    {
        return $_SESSION['USERTYPE'];
    }
    public static function isLogged()
    {
        if (!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION['LAST_ACTIVITY'])){
            return false;
        }
        $last = $_SESSION['LAST_ACTIVITY'];
        if(time() - $last > 1800){
            try {

                unset($_SESSION['USERID']);
//                if(session_destroy()){
//
//                }
            }catch (Exception $e){

            }
        }else{
            $_SESSION['LAST_ACTIVITY'] = time();
        }

        return isset($_SESSION['USERID']);
    }
    public static function getUserID()
    {
        return $_SESSION['USERID'];
    }

    public static function sendHome()
    {
        header('Location: '.self::home());
    }
    public static function setMessage($param)
    {
        $_SESSION['_msg'] =  $param;
    }
    public static function getMessage()
    {
        if(!isset($_SESSION['_msg']))
        {
            return null;
        }
        $msg =  $_SESSION['_msg'];
        $_SESSION['_msg'] =  null;
        return $msg;
    }
    public static function setError($param)
    {
        $_SESSION['_error'] =  $param;
    }
    public static function getError()
    {
        if(!isset($_SESSION['_error']))
        {
            return null;
        }
        $msg =  $_SESSION['_error'];
        $_SESSION['_error'] =  null;
        return $msg;
    }


    public static function home(){
        return App::APP_DOMAIN;
    }

    public static function generateRandomString($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}





?>

