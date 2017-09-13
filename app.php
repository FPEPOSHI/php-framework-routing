<?php
/**
 * Created by PhpStorm.
 * User: fpeposhi
 * Date: 5/11/17
 * Time: 9:48 AM
 */
//$url = $_SERVER['REQUEST_URI'];
//
//var_dump(parse_url($url));

session_start();
date_default_timezone_set('Europe/Tirane');
ob_start();
define("VALID_DIR", "test");

include_once "App/core/main.php";
?>
<!DOCTYPE html>
<html>
 <body>


    <?php

    App::main();

    ?>


</body>
</html>
