<?php

/**
 * IosController
 */
class IosController extends baseController {

    private $iosModel;
    private $pagination;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->iosModel = $this->load->model('Ios');
        $this->pagination = $this->load->library('Pagination');
    }

    /**
     * 主页推荐
     */
    public function main_recommend()
    {
        $url = '/ios/main_recommend';
        $this->checkPermission($this->userInfo['permission'], $url);

        if(count($this->input->post()) > 0){
            $conf = trim($this->input->post('conf'));
            $try = json_decode($conf, true);
            if(is_array($try)){
                $this->iosModel->setMainRecommendConf($conf);
                $data['success'] = '保存成功！配置将在一小时后生效~';
            }else{
                $data['error'] = 'JSON格式错误！！！';
            }
        }

        $data['conf'] = $this->iosModel->getMainRecommendConf();

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '主页推荐';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('ios/main_recommend', $data);
        $this->load->view('general/footer');
    }

    /**
     * 升级提示
     */
    public function new_version()
    {
        $url = '/ios/new_version';
        $this->checkPermission($this->userInfo['permission'], $url);

        if(count($this->input->post()) > 0){
            $conf = trim($this->input->post('conf'));
            $try = json_decode($conf, true);
            if(is_array($try)){
                $this->iosModel->setNewVersionConf($conf);
                $data['success'] = '保存成功！配置将在一小时后生效~';
            }else{
                $data['error'] = 'JSON格式错误！！！';
            }
        }

        $data['conf'] = $this->iosModel->getNewVersionConf();

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '升级提示';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('ios/new_version', $data);
        $this->load->view('general/footer');
    }

    /**
     * 意见反馈
     */
    public function feedback_list()
    {
        $url = '/ios/feedback_list';
        $this->checkPermission($this->userInfo['permission'], $url);

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $content = trim($this->input->post('content'));
        $page = trim($this->input->post('page'));
        $act = trim($this->input->post('act'));
        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*15);
            $endDate = date('Y-m-d', time() - 86400);
        }
        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $count = $this->iosModel->getFeedbackCount($startDate, $endDate, $content);
            $perPage = 100;
            $allPage = ceil($count / $perPage);
            if($page > $allPage) $page = $allPage;
            if($page <= 0) $page = 1;
            $start = $perPage * ($page - 1);

            $data['page'] = $this->pagination->getPage($page, $allPage);
            $data['feedbackList'] = $this->iosModel->getFeedbackList($startDate, $endDate, $content,  $start, $perPage);
            $data['count'] = $count;
            $data['allPage'] = $allPage;
        }

        $data['userInfo'] = $this->userInfo;

        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['content'] = $content;

        $data['url'] = $url;
        $data['title'] = '意见反馈';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('ios/feedback_list', $data);
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