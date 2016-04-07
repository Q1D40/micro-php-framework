<?php

/**
 * mysql
 */
class MySql {

    protected static $instance;
    protected $dbconn;

    /**
     * 构造函数
     */
    protected function __construct()
    {
        // TODO
    }

    /**
     * 查询所有记录
     * @param $sql
     * @return array
     */
    public function fetchAll($sql)
    {
        $rs = $this->query($sql);
        while($row = @mysql_fetch_assoc($rs)){
            $arr[] = $row;
        }
        return @$arr;
    }

    /**
     * 获取单例
     * @return MySql
     */
    public static function getSingleton()
    {
        if(!isset(self::$instance))
            self::$instance = new MySql();
        return self::$instance;
    }

    /**
     * sql语句查询
     * @param $sql
     * @return resource
     */
    public function query($sql, &$affectedRows = 0)
    {
        $this->connect();
        $rs = mysql_query($sql);
        $affectedRows = mysql_affected_rows();
        return $rs;
    }

    /**
     * 数据库连接
     */
    protected function connect()
    {
        if(!isset($this->dbconn)){
            $config = include(dirname(__FILE__) . "/../application/config/config.php");
            $this->dbconn = mysql_connect($config['mysql']['host'] . ":" . $config['mysql']['port'], $config['mysql']['user'], $config['mysql']['password']);
            mysql_select_db($config['mysql']['dbPrefix'] . $config['mysql']['db'], $this->dbconn);
            mysql_query("set names 'UTF8'");
        }
    }

}
