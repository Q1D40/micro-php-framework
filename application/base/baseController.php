<?php

/**
 * baseController
 */
class baseController extends Controller {

    public $userInfo;

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();

        $userModel = $this->load->model('User');
        $this->userInfo = $this->session->getCookie('sxus');
        $this->makeUserInfoPermission($this->userInfo['permission'], $userModel->getPermissionList());

        $this->checkUserAgent();
        $this->checkLogin();
    }

    /**
     * 用户权限
     * @param $userPermission
     * @param $permissionList
     */
    private function makeUserInfoPermission(&$userPermission, $permissionList)
    {
        $userPermissionArr = explode('|', $userPermission);
        $data = array();
        foreach($permissionList as $permission){
            if(in_array($permission['id'], $userPermissionArr))
                $data[] = $permission;
        }
        $userPermission = $data;
    }

    /**
     * 检查UserAgent
     */
    private function checkUserAgent()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $pos = strpos($userAgent, 'hellosixiang');
        if ($pos === false) {
            Error::error404();
        }
    }

    /**
     * 检查登录
     */
    private function checkLogin()
    {
        if(@$this->userInfo['login'] !== 'true')
            $this->url->redirect('user/login');
    }

    /**
     * 检查权限
     */
    protected function checkPermission($permission, $url)
    {
        $b = false;
        foreach($permission as $row){
            if($row['level'] == 4 && $row['url'] == $url) {
                $b = true;
                break;
            }
        }
        if(!$b)
            Error::noPermission();
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}