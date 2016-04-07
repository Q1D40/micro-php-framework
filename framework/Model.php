<?php

include_once(dirname(__FILE__) . '/MySql.php');

/**
 * Model
 */
class Model extends Base {

    protected $mysql;

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->mysql = &MySql::getSingleton();
    }

    /**
     * singleton
     */
    public static function getSingleton()
    {
        return false;
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}