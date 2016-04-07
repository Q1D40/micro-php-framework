<?php

include_once(dirname(__FILE__) . '/Base.php');
include_once(dirname(__FILE__) . '/Load.php');
include_once(dirname(__FILE__) . '/Task.php');

/**
 * Cron
 */
class Cron extends Base {

    protected static $instance;
    private $cronConf;

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->cronConf = $this->load->config('cron');
        $this->load->base();
    }

    /**
     * group
     */
    public function group()
    {
        // TODO 分组启动
        // TODO 此处添加group启动日志
        $argv = $_SERVER['argv'];
        unset($argv[0]);
        foreach($conf[$argv[1]] as $pro){
            system(PHP_PATH . ' -n ' . CRON_PATH . $pro . ' > ' . CRON_PATH . 'out &');
        }
        // TODO 此处更新group启动日志
    }

    /**
     * process
     */
    public function process()
    {
        // TODO 启动一个进程
        $argv = $_SERVER['argv'];
        unset($argv[0]);
        $this->run($class, $method, $argv);
    }

    /**
     * run
     */
    private function run($class, $method, $param)
    {
        // TODO 启动一个任务 检查互斥 记录运行日志
        $name = $class . '_' . $method;
        if(count($args) > 0)
            $name .= '_' . implode('_', $args);
        $this->mutex($name);

        $this->addLockFile($name);
        $logId = $this->addLog(array('pid' => getmypid(), 'startTime' => time(), 'type' => $name, 'date' => date('Y-m-d', time())));

        $this->load->task($class, $method, $param);

        $this->updateLog(array('memory' => memory_get_usage(), 'endTime' => time()), $logId);
        $this->delLockFile($name);
    }

    /**
     * 进程互斥
     */
    private function mutex($name)
    {
        $lockFile = $this->lockPath . $name . '.lock';
        if(file_exists($lockFile)){
            $timeLong = time() - filectime($lockFile);
            $timeOut = $this->config['cron']['timeOut'][$name] + 0;
            if($timeOut == 0) $timeOut = $this->config['cron']['timeOut']['default'] + 0;
            if($timeLong > $timeOut && $timeOut > 0){
                // 进程超时
                $this->delLockFile($name);
                $logArr = array('type' => 'processTimeOut', 'ext1' => $name, 'ext2' => $timeLong, 'date' => date('Y-m-d', time()),'timeStamp' => time());
                $this->addwarningLog($logArr);
            }else{
                exit();
            }
        }
    }

    /**
     * 添加锁文件
     */
    private function addLockFile($name)
    {
        $lockFile = $this->lockPath . $name . '.lock';
        file_put_contents($lockFile, '');
    }

    /**
     * 删除锁文件
     */
    private function delLockFile($name)
    {
        $lockFile = $this->lockPath . $name . '.lock';
        unlink($lockFile);
    }

    /**
     * 添加日志
     */
    private function addLog($arr)
    {
        foreach ($arr as $field => $value) {
            $fieldArray[] = '`' . $field . '`';
            $valueArray[] = "'" . $value . "'";
        }
        $fieldStr = implode(',', $fieldArray);
        $valueStr = implode(',', $valueArray);
        $sql = "INSERT INTO " . $this->config['db']['dbPrefix'] . "cron.`cronLog` ($fieldStr) VALUES ($valueStr)";
        $this->db->setData($sql);
        return mysql_insert_id();
    }

    /**
     * 更新日志
     */
    private function updateLog($arr, $id)
    {
        $set = '';
        foreach ($arr as $field => $value) {
            if($set == ''){
                $set .= " `" . $field . "` = '" . $value . "' ";
            }else{
                $set .= ", `" . $field . "` = '" . $value . "' ";
            }
        }
        $sql = "UPDATE " . $this->config['db']['dbPrefix'] . "cron.`cronLog` SET $set WHERE `id`='$id' LIMIT 1";
        $this->db->setData($sql);
    }

    /**
     * 添加报警日志
     */
    private function addwarningLog($arr)
    {
        foreach ($arr as $field => $value) {
            $fieldArray[] = '`' . $field . '`';
            $valueArray[] = "'" . $value . "'";
        }
        $fieldStr = implode(',', $fieldArray);
        $valueStr = implode(',', $valueArray);
        $sql = "INSERT INTO " . $this->config['db']['dbPrefix'] . "cron.`warningLog` ($fieldStr) VALUES ($valueStr)";
        $this->db->setData($sql);
    }

    /**
     * singleton
     */
    public static function getSingleton()
    {
        if(!isset(self::$instance))
            self::$instance = new Cron();
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
