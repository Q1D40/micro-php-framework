<?php

class TfController extends baseController {

    private $tfModel;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->tfModel = $this->load->model('Tf');
    }

    /**
     * 关键字类型
     */
    public function keyword_type()
    {
        $url = '/tf/keyword_type';
        $this->checkPermission($this->userInfo['permission'], $url);

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '关键字类型';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('tf/keyword_type', $data);
        $this->load->view('general/footer');
    }

    /**
     * 关键字列表
     */
    public function keyword_list()
    {
        $url = '/tf/keyword_list';
        $this->checkPermission($this->userInfo['permission'], $url);

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '关键字列表';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('tf/keyword_list', $data);
        $this->load->view('general/footer');
    }

    /**
     * 关键字信息导入数据库
     */
    public function keyword_import()
    {
        $url = '/tf/keyword_import';
        $this->checkPermission($this->userInfo['permission'], $url);

        if(count($this->input->post()) >0){
            $conf = trim($this->input->post('conf'));
            $confArr = explode('\n', $conf);
            foreach($confArr as $row){
                $rowArr = explode('\t',$row);
                var_dump($rowArr);
            }
        }

        $data['userInfo'] = $this->userInfo;

        $data['url'] = $url;
        $data['title'] = '关键字导入';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('tf/keyword_import', $data);
        $this->load->view('general/footer');
    }
}