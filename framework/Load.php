<?php

include_once(dirname(__FILE__) . '/Error.php');

/**
 * Load
 */
class Load {

    protected static $instance;
    private     $baseDir;
    private     $viewPath;
    private     $modelPath;
    private     $controllerPath;
    private     $basePath;
    private     $libraryPath;
    private     $helperPath;
    private     $taskPath;
    protected   $conf;

    /**
     * construct
     */
    public function __construct()
    {
        $this->baseDir = dirname(__FILE__) . "/../";
        $this->conf = include($this->baseDir . "application/config/config.php");
        $this->viewPath = $this->baseDir . "application/view/";
        $this->modelPath = $this->baseDir . "application/model/";
        $this->controllerPath = $this->baseDir . "application/controller/";
        $this->taskPath = $this->baseDir . "application/task/";
        $this->basePath = $this->baseDir . "application/base/";
        $this->libraryPath = $this->baseDir . "application/library/";
        $this->helperPath = $this->baseDir . "application/helper/";
    }

    /**
     * view
     */
    public function view($fileName, $data = array())
    {
        $this->helper('View');
        @extract($data, EXTR_OVERWRITE);
        include_once($this->viewPath . strtolower($fileName) . ".php");
    }

    /**
     * model
     */
    public function model($model)
    {
        include_once($this->modelPath . ucfirst(strtolower($model)) . ".php");
        $model = ucfirst(strtolower($model)) . 'Model';
        return new $model();
    }

    /**
     * controller
     */
    public function controller($controller, $action, $param = '')
    {
        if($action == '') $action = 'index';
        $class = $controller . 'Controller';
        $method = $action;
        $controllerFile = $this->controllerPath . $controller . ".php";
        if(file_exists($controllerFile)){
            include_once($controllerFile);
        }else{
            Error::error404();
        }
        if(class_exists($class)){
            $obj = new $class();
            if(method_exists($obj, $method)){
                call_user_func_array(array($obj, $method), array($param));
            }else{
                Error::error404();
            }
        }else{
            Error::error404();
        }
    }

    /**
     * task
     */
    public function task($class, $method, $param = '')
    {
        $classFile = $this->taskPath . $class . ".php";
        if(file_exists($classFile)){
            include_once($classFile);
        }else{
            Error::runClassFileNotExists();
        }
        if(class_exists($class)){
            $obj = new $class();
            if(method_exists($obj, $method)){
                call_user_func_array(array($obj, $method), array($param));
            }else{
                Error::runClassMethodNotExists();
            }
        }else{
            Error::runClassNotExists();
        }
    }

    /**
     * config
     */
    public function config($key)
    {
        return $this->conf[$key];
    }

    /**
     * base
     */
    public function base()
    {
        if(!is_dir($this->basePath)) return;
        $handle  = opendir($this->basePath);
        while( false !== ($file = readdir($handle))){
            $pathInfo = pathinfo($file);
            if($file != '.' && $file != '..' && $pathInfo["extension"] == 'php'){
                include_once($this->basePath . $file);
            }
        }
    }

    /**
     * library
     */
    public function library($library)
    {
        include_once($this->libraryPath . $library . ".php");
        return new $library();
    }

    /**
     * helper
     */
    public function helper($helper)
    {
        include_once($this->helperPath . $helper . ".php");
    }

    /**
     * singleton
     */
    public static function getSingleton()
    {
        if(!isset(self::$instance))
            self::$instance = new Load();
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
