<?php

/**
 * IosModel
 */
class IosModel extends Model {

    private $mysqlConf;
    private $generalconfModel;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->mysqlConf = $this->load->config('mysql');
        $this->generalconfModel = $this->load->model('Generalconf');
    }

    /**
     * 获取主页推荐配置
     * @return mixed
     */
    public function getMainRecommendConf()
    {
        $data = $this->generalconfModel->getGeneralConf(1);
        return $data['f1'];
    }

    /**
     * 设置主页推荐配置
     * @param $conf
     * @return mixed
     */
    public function setMainRecommendConf($conf)
    {
        $data['f1'] = $conf;
        $data['timeStamp'] = time();
        return $this->generalconfModel->setGeneralConf($data, 1);
    }

    /**
     * 获取新版本配置
     * @return mixed
     */
    public function getNewVersionConf()
    {
        $data = $this->generalconfModel->getGeneralConf(2);
        return $data['f1'];
    }

    /**
     * 设置新版本配置
     * @param $conf
     * @return mixed
     */
    public function setNewVersionConf($conf)
    {
        $data['f1'] = $conf;
        $data['timeStamp'] = time();
        return $this->generalconfModel->setGeneralConf($data, 2);
    }

    /**
     * 获取意见反馈列表
     * @param $startDate
     * @param $endDate
     * @param $content
     * @param $start
     * @param $limit
     * @return array
     */
    public function getFeedbackList($startDate, $endDate, $content, $start, $limit)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate) + 86400;
        $where = " WHERE `timeStamp` >= $startDate AND `timeStamp` < $endDate";
        if($content !== '')
            $where .= " AND `content` LIKE '%$content%'";
        $limit = " LIMIT $start, $limit";
        $sql = "SELECT * FROM " . $this->mysqlConf['dbPrefix'] . "work.`ios_feedback` $where ORDER BY `id` DESC $limit";
        $row = $this->mysql->fetchAll($sql);
        return $row;
    }

    /**
     * 获取意见反馈条目
     * @param $startDate
     * @param $endDate
     * @param $content
     * @return mixed
     */
    public function getFeedbackCount($startDate, $endDate,$content)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate) + 86400;
        $where = " WHERE `content` != '' AND `timeStamp` >= $startDate AND `timeStamp` < $endDate";
        if($content !== '')
            $where .= " AND `content` LIKE '%$content%'";
        $sql = "SELECT COUNT(*) AS `num` FROM " . $this->mysqlConf['dbPrefix'] . "work.`ios_feedback` $where";
        $row = $this->mysql->fetchAll($sql);
        return $row[0]['num'];
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}