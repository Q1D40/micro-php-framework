<?php

/**
 * Url
 */
class Url {

    protected static $instance;

    /**
     * construct
     */
    public function __construct()
    {
        // TODO
    }

    /**
     * redirect
     */
    public function redirect($url)
    {
        header('Location: /' . $url);
    }

    /**
     * singleton
     */
    public static function getSingleton()
    {
        if(!isset(self::$instance))
            self::$instance = new Url();
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