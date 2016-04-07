<?php

/**
 * GeneralconfModel
 */
class GeneralconfModel extends Model {

    private $mysqlConf;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->mysqlConf = $this->load->config('mysql');
    }

    /**
     * 更新通用设置
     */
    public function setGeneralConf($data, $id)
    {
        foreach ($data as $field => $value) {
            $fieldAndValueArray[] = "`$field` = '$value'";
        }
        $fieldAndValueStr = implode(',', $fieldAndValueArray);
        $sql = "UPDATE " . $this->mysqlConf['dbPrefix'] . "work.general_conf SET $fieldAndValueStr WHERE `id` = '$id' LIMIT 1";
        $affectedRows = 0;
        $this->mysql->query($sql, $affectedRows);
        return $affectedRows;
    }

    /**
     * 获取通用设置
     */
    public function getGeneralConf($id)
    {
        $sql = "SELECT * FROM " . $this->mysqlConf['dbPrefix'] . "work.general_conf WHERE id = '$id' LIMIT 1";
        $row = $this->mysql->fetchAll($sql);
        return $row[0];
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}