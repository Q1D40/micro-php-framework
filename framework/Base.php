<?php

/**
 * Base
 */
abstract class Base {

    protected $load;

    /**
     * construct
     */
    public function __construct()
    {
        $this->load = &Load::getSingleton();
    }

    /**
     * singleton
     */
    abstract public static function getSingleton();

    /**
     * destruct
     */
    public function __destruct()
    {
        // TODO
    }
}