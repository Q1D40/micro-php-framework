<?php

/**
 * UserController
 */
class UserController extends Controller {

    private $userInfo;
    private $userModel;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->userModel = $this->load->model('User');

        $this->userInfo = $this->session->getCookie('sxus');
        $this->makeUserInfoPermission($this->userInfo['permission'], $this->userModel->getPermissionList());
    }

    /**
     * 用户登陆
     */
    public function login()
    {
        $this->checkUserAgent();
        $this->checkLogout();

        if(count($this->input->post()) > 0){
            $code = $this->input->post('code');
            $scode = $this->session->getCookie('code');
            $this->session->delCookie('code');
            if($code != $scode || trim($code) == ''){
                $data['error'] = '验证码错误';
            }else{
                $userName = strtolower(trim($this->input->post('userName')));
                $passWord = md5(strtolower(trim($this->input->post('passWord'))));
                $userInfo = $this->userModel->checkUser($userName, $passWord);
                if(@$userInfo['uid'] > 0){
                    $userSession = array(
                        'uid'           => $userInfo['uid'],
                        'userName'      => $userInfo['userName'],
                        'permission'    => $userInfo['permission'],
                        'login'         => 'true',
                    );
                    $this->session->setCookie('sxus', $userSession);
                    $this->url->redirect('');
                }else{
                    $data['error'] = '用户名或密码错误！';
                }
            }
        }
        $this->load->view('user/login', @$data);
    }

    /**
     * 用户注销
     */
    public function logout()
    {
        $this->session->delCookie('sxus');
        $this->url->redirect('user/login');
    }

    /**
     * 生成验证码
     */
    public function create_captcha()
    {
        $captcha = $this->load->library('Captcha');
        $captcha->create();
        $this->session->setCookie('code', $captcha->code, 60*5);
    }

    /**
     * 检查登出
     */
    private function checkLogout()
    {
        if(@$this->userInfo['login'] === 'true')
            $this->url->redirect('user/welcome');
    }

    /**
     * 检查登陆
     */
    private function checkLogin()
    {
        if($this->userInfo['login'] !== 'true')
            $this->url->redirect('user/login');
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
     * 检查权限
     */
    private function checkPermission($permission, $url)
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
     * 权限列表
     */
    public function permission_list($param)
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $url = '/user/permission_list';
        $this->checkPermission($this->userInfo['permission'], $url);

        $param = explode('/', $param);
        $pid = $param[0] + 0;
        $data['pPermission'] = $this->userModel->getPermissionById($pid);
        $data['permissionList'] = $this->userModel->getPermissionListByPid($pid);

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '权限管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('user/permission_list', $data);
        $this->load->view('general/footer');
    }

    /**
     * 权限添加
     */
    public function permission_add($param)
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $url = '/user/permission_list';
        $this->checkPermission($this->userInfo['permission'], $url);

        $param = explode('/', $param);
        $pid = $param[0] + 0;

        if(count($this->input->post()) > 0){
            $pPermission = $this->userModel->getPermissionById($pid);
            if($pPermission['level'] == '')
                $level = 1;
            else
                $level = $pPermission['level'] + 1;
            $pdata = array(
                'pid'       => $pid,
                'name'      => trim($this->input->post('name')),
                'url'       => trim($this->input->post('url')),
                'status'    => trim($this->input->post('status')),
                'level'     => $level,
                'sort'      => trim($this->input->post('sort'))
            );
            $this->userModel->addPermission($pdata);
            $this->url->redirect('user/permission_list/' . $pid);
        }

        $data['pid'] = $pid;

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '权限管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('user/permission_edit', $data);
        $this->load->view('general/footer');
    }

    /**
     * 权限编辑
     */
    public function permission_edit($param)
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $url = '/user/permission_list';
        $this->checkPermission($this->userInfo['permission'], $url);

        $param = explode('/', $param);
        $id = $param[0] + 0;

        $permission = $this->userModel->getPermissionById($id);

        if(count($this->input->post()) > 0){
            $pdata = array(
                'id'        => $id,
                'name'      => trim($this->input->post('name')),
                'url'       => trim($this->input->post('url')),
                'status'    => trim($this->input->post('status')),
                'sort'      => trim($this->input->post('sort'))
            );
            $cpermission = $this->userModel->getPermissionById($id);
            if($pdata['status'] == 1){
                $ifStatus = $this->userModel->canOpenPermissionList($cpermission['pid']);
            }else{
                $ifStatus = $this->userModel->canClosePermissionList($cpermission['id']);
            }
            if($ifStatus){
                $this->userModel->editPermission($pdata);
                $this->url->redirect('user/permission_list/' . $permission['pid']);
            }else{
                if($pdata['status'] == 1) {
                    $data['error'] = '启用失败！父菜单仍有未启用项。';
                }else{
                    $data['error'] = '禁用失败！子菜单仍有未禁用项。';
                }
            }
        }

        $data['permission'] = $permission;
        $data['pid'] = $permission['pid'];

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '权限管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('user/permission_edit', $data);
        $this->load->view('general/footer');
    }

    /**
     * 用户列表
     */
    public function user_list()
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $url = '/user/user_list';
        $this->checkPermission($this->userInfo['permission'], $url);

        $data['userList'] = $this->userModel->getUserList();

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '用户管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('user/user_list', $data);
        $this->load->view('general/footer');
    }

    /**
     * 用户添加
     */
    public function user_add()
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $url = '/user/user_list';
        $this->checkPermission($this->userInfo['permission'], $url);

        if(count($this->input->post()) > 0){
            $permission = implode('|', $this->input->post('permission'));
            $userName = strtolower(trim($this->input->post('userName')));
            $passWord = trim($this->input->post('passWord'));
            $status = trim($this->input->post('status'));
            $user = $this->userModel->getUserByUserName($userName);
            if($user['uid'] > 0){
                $data['error'] = '用户名已存在！';
            }else{
                $this->userModel->addUser($userName, md5($passWord), $permission, $status);
                $this->url->redirect('user/user_list');
            }
        }

        $data['permissionTree'] = $this->getPermissionTree();

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '用户管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('user/user_edit', $data);
        $this->load->view('general/footer');
    }

    /**
     * 用户编辑
     */
    public function user_edit($param)
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $url = '/user/user_list';
        $this->checkPermission($this->userInfo['permission'], $url);

        $param = explode('/', $param);
        $uid = $param[0] + 0;

        $user = $this->userModel->getUserByUid($uid);

        if(count($this->input->post()) > 0){
            $permission = implode('|', $this->input->post('permission'));
            $userName = strtolower(trim($this->input->post('userName')));
            $passWord = trim($this->input->post('passWord'));
            $status = trim($this->input->post('status'));
            if($userName != $user['userName'])
                $cuser = $this->userModel->getUserByUserName($userName);
            if($cuser['uid'] > 0){
                $data['error'] = '用户名已存在！';
            }else{
                if($passWord == '')
                    $passWord = $user['passWord'];
                else
                    $passWord = md5($passWord);
                $this->userModel->editUser($userName, $passWord, $permission, $status, $uid);
                $this->url->redirect('user/user_list');
            }
        }

        $data['permissionTree'] = $this->getPermissionTree();

        $data['userInfo'] = $this->userInfo;

        $user['permission'] = explode('|', $user['permission']);
        $data['user'] = $user;

        $data['url'] = $url;
        $data['title'] = '用户管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('user/user_edit', $data);
        $this->load->view('general/footer');
    }

    /**
     * 获取权限关联数据
     */
    private function getPermissionTree()
    {
        $permissionList = $this->userModel->getPermissionList();
        $rootArr = $this->getPermissionByPid($permissionList, 0);
        foreach($rootArr as $key1 => $row1){
            $arr1 = $this->getPermissionByPid($permissionList, $row1['id']);
            $rootArr[$key1]['sub'] = $arr1;
            foreach($arr1 as $key2 => $row2){
                $arr2 = $this->getPermissionByPid($permissionList, $row2['id']);
                $rootArr[$key1]['sub'][$key2]['sub'] = $arr2;
                foreach($arr2 as $key3 => $row3){
                    $arr3 = $this->getPermissionByPid($permissionList, $row3['id']);
                    $rootArr[$key1]['sub'][$key2]['sub'][$key3]['sub'] = $arr3;
                }
            }
        }
        return $rootArr;
    }

    /**
     * 根据父id找权限
     * @param $permissionList
     * @param $pid
     * @return array $arr
     */
    private function getPermissionByPid($permissionList, $pid)
    {
        $arr = array();
        foreach($permissionList as $row){
            if($row['pid'] == $pid)
                $arr[] = $row;
        }
        return $arr;
    }

    /**
     * 欢迎页
     */
    public function welcome()
    {
        $this->checkUserAgent();
        $this->checkLogin();

        $data['userInfo'] = $this->userInfo;

        $data['title'] = '桔子';

        $hour = date("H", time());
        if($hour < 6)      $data["hello"] = "夜猫子，该睡觉了!!!";
        elseif($hour < 8)  $data["hello"] = "新的一天开始了哦!";
        elseif($hour < 9)  $data["hello"] = "早餐吃了吗?";
        elseif($hour < 10) $data["hello"] = "好心情 好运气!";
        elseif($hour < 11) $data["hello"] = "欢迎来到地球~";
        elseif($hour < 12) $data["hello"] = "工作辛苦了!";
        elseif($hour < 13) $data["hello"] = "别忘了吃午饭哦!";
        elseif($hour < 14) $data["hello"] = "没有午休的习惯啊?";
        elseif($hour < 15) $data["hello"] = "保持积极的心态!!";
        elseif($hour < 16) $data["hello"] = "相逢的人会再相逢!";
        elseif($hour < 18) $data["hello"] = "今天工作还顺利吧?!";
        elseif($hour < 20) $data["hello"] = "终于等到你了 ^_^";
        elseif($hour < 22) $data["hello"] = "晚上别玩得太晚了哦!";
        elseif($hour < 24) $data["hello"] = "夜深了!记得早点休息呀!";

        $this->load->view('general/header', $data);
        $this->load->view('user/welcome', $data);
        $this->load->view('general/footer');
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}