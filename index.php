<?php

include_once(dirname(__FILE__) . '/framework/Route.php');

$debugFile = dirname(__FILE__) . '/debug.php';
if(file_exists($debugFile))
    include_once($debugFile);

if(defined('DEBUG')){
    ini_set("display_errors",1);
}else{
    ini_set("display_errors",0);
}

/**
 * fire
 */
Route::getSingleton()->____();