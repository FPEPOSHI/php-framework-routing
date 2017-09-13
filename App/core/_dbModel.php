<?php

/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 7/31/17
 * Time: 2:03 PM
 */
class _dbModel
{

    private static $instance = NULL;
//    private static $host = '192.168.50.82';
    private static $host = 'localhost';
    private static $uname = 'root';
    private static $pasw = '';
    private static $name = 'parking';
    private static $type = 'mysql';


    private function __construct()
    {
    }

    public static function getInstance()
    {

        try{

            if (!self::$instance) {
                self::$instance = new PDO("" . self::$type .  ":dbname=" . self::$name .";host=" . self::$host .";port=3306", self::$uname, self::$pasw);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

        }catch (PDOException $e){
            echo $e->getMessage();die();
        }


        return self::$instance;
    }

    private function __clone()
    {

    }


}

