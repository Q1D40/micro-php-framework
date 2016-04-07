<?php

include_once(dirname(__FILE__) . '/Base.php');
include_once(dirname(__FILE__) . '/Load.php');
include_once(dirname(__FILE__) . '/Controller.php');
include_once(dirname(__FILE__) . '/Model.php');

/**
 * Route
 */
class Route extends Base {

    protected static $instance;
    private $routeConf;

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->routeConf = $this->load->config('route');
        $this->load->base();
    }

    /**
     * enter
     */
    public function ____()
    {
        $requestUrl = trim($_SERVER['REQUEST_URI']);
        if($requestUrl == '/') $requestUrl .= $this->routeConf['default'];
        $arr = explode('/', $requestUrl);
        $controller = ucfirst(strtolower(trim($arr[1])));
        $action = strtolower(trim(@$arr[2]));
        unset($arr[0]);
        unset($arr[1]);
        unset($arr[2]);
        $param = implode('/', $arr);
        $this->load->controller($controller, $action, $param);
    }

    /**
     * singleton
     */
    public static function getSingleton()
    {
        if(!isset(self::$instance))
            self::$instance = new Route();
        return self::$instance;
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        parent::__destruct();
    }

}
