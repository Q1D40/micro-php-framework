<?php

/**
 * Input
 */
class Input {

    protected static $instance;

    /**
     * construct
     */
    public function __construct()
    {
        // TODO
    }

    /**
     * get
     */
    public function get($key = null)
    {
        if($key == null){
            return $_GET;
        }else{
            return @$_GET[$key];
        }
    }

    /**
     * post
     */
    public function post($key = null)
    {
        if($key == null){
            return $_POST;
        }else{
            return @$_POST[$key];
        }
    }

    /**
     * singleton
     */
    public static function getSingleton()
    {
        if(!isset(self::$instance))
            self::$instance = new Input();
        return self::$instance;
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        // TODO
    }
}