<?php

/**
 * Session
 */
class Session {

    protected static $instance;
    private $cookieTimeOut;
    /**
     * construct
     */
    public function __construct()
    {
        $this->cookieTimeOut = 3600*24*30;
    }

    /**
     * setCookie
     */
    public function setCookie($key, $value, $timeOut = 0)
    {
        if($timeOut == 0) $timeOut = $this->cookieTimeOut;
        $timeOut += time();
        setcookie($key, serialize($value), $timeOut, '/');
    }

    /**
     * getCookie
     */
    public function getCookie($key)
    {
        return @unserialize($_COOKIE[$key]);
    }

    /**
     * delCookie
     */
    public function delCookie($key)
    {
        setcookie($key, "", time() - 3600, '/');
    }

    /**
     * singleton
     */
    public static function getSingleton()
    {
        if(!isset(self::$instance))
            self::$instance = new Session();
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