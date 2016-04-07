<?php

/**
 * Error
 */
class Error {

    /**
     * construct
     */
    public function __construct()
    {
        // TODO
    }

    /**
     * error404
     */
    public static function error404()
    {
        header('HTTP/1.1 404 Not Found');
        header("status: 404 Not Found");
        exit('404 Not Found');
    }

    /**
     * no permission
     */
    public static function noPermission()
    {
        exit('no permission');
    }

    /**
     * run class file not exists
     */
    public static function runClassFileNotExists()
    {
        exit('run class file not exists');
    }

    /**
     * run file not exists
     */
    public static function runClassNotExists()
    {
        exit('run file not exists');
    }

    /**
     * run class method not exists
     */
    public static function runClassMethodNotExists()
    {
        exit('run class method not exists');
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        // TODO
    }
}
