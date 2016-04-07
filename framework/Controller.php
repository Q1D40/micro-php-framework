<?php

/**
 * Controller
 */
class Controller extends Base {

    protected $session;
    protected $url;
    protected $input;

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('Session');
        $this->load->helper('Url');
        $this->load->helper('Input');
        $this->session = &Session::getSingleton();
        $this->url = &Url::getSingleton();
        $this->input = &Input::getSingleton();
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