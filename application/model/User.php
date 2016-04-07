<?php

/**
 * UserModel
 */
class UserModel extends Model {

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
     * 验证用户名密码
     */
    public function checkUser($userName, $passWord)
    {
        $sql = "SELECT * FROM " . $this->mysqlConf['dbPrefix'] . "backstage.user WHERE `userName` = '$userName' AND `passWord` = '$passWord' AND `status` = '1' LIMIT 1";
        $row = $this->mysql->fetchAll($sql);
        return $row[0];
    }

    /**
     * 获取用户列表
     */
    public function getUserList()
    {
        $sql = "SELECT * FROM " . $this->mysqlConf['dbPrefix'] . "backstage.user ORDER BY `uid` DESC";
        $row = $this->mysql->fetchAll($sql);
        return $row;
    }

    /**
     * 添加用户
     */
    public function addUser($userName, $passWord, $permission, $status)
    {
        $sql = "INSERT INTO " . $this->mysqlConf['dbPrefix'] . "backstage.user (`userName`, `passWord`, `permission`, `status`)
                VALUES
                ('$userName', '$passWord', '$permission', '$status')";
        $this->mysql->query($sql, $affectedRows);
        return $affectedRows;
    }

    /**
     * 编辑用户
     */
    public function editUser($userName, $passWord, $permission, $status, $uid)
    {
        $sql = "UPDATE " . $this->mysqlConf['dbPrefix'] . "backstage.user SET `userName` = '$userName', `passWord` = '$passWord', `permission` = '$permission', `status` = '$status' WHERE uid = '$uid' LIMIT 1";
        $this->mysql->query($sql, $affectedRows);
        return $affectedRows;
    }

    /**
     * 用户名获取用户
     */
    public function getUserByUserName($userName)
    {
        $sql = "SELECT * FROM " . $this->mysqlConf['dbPrefix'] . "backstage.user WHERE `userName` = '$userName' LIMIT 1";
        $row = $this->mysql->fetchAll($sql);
        return $row[0];
    }

    /**
     * uid获取用户
     */
    public function getUserByUid($uid)
    {
        $sql = "SELECT * FROM " . $this->mysqlConf['dbPrefix'] . "backstage.user WHERE `uid` = '$uid' LIMIT 1";
        $row = $this->mysql->fetchAll($sql);
        return $row[0];
    }

    /**
     * 获取权限列表
     */
    public function getPermissionList()
    {
        $sql = "SELECT * FROM " . $this->mysqlConf['dbPrefix'] . "backstage.permission WHERE `status` = '1' ORDER BY `sort` DESC";
        $row = $this->mysql->fetchAll($sql);
        return $row;
    }

    /**
     * 获取权限列表
     */
    public function getPermissionListByPid($pid)
    {
        $sql = "SELECT * FROM " . $this->mysqlConf['dbPrefix'] . "backstage.permission WHERE `pid` = '" . $pid . "' ORDER BY `sort` DESC";
        $row = $this->mysql->fetchAll($sql);
        return $row;
    }

    /**
     * 添加权限
     */
    public function addPermission($data)
    {
        $sql = "INSERT INTO " . $this->mysqlConf['dbPrefix'] . "backstage.permission (`pid`, `name`, `url`, `status`, `level`, `sort`)
                VALUES
                ('" . $data['pid'] . "', '" . $data['name'] . "', '" . $data['url'] . "', '" . $data['status'] . "', '" . $data['level'] . "', '" . $data['sort'] . "')";
        $affectedRows = 0;
        $this->mysql->query($sql, $affectedRows);
        return $affectedRows;
    }

    /**
     * 编辑权限
     */
    public function editPermission($data)
    {
        $sql = "UPDATE " . $this->mysqlConf['dbPrefix'] . "backstage.permission SET `name` = '" . $data['name'] . "', `url` = '" . $data['url'] . "', `status` = '" . $data['status'] . "', `sort` = '" . $data['sort'] . "' WHERE id = '" . $data['id'] . "' LIMIT 1";
        $affectedRows = 0;
        $this->mysql->query($sql, $affectedRows);
        return $affectedRows;
    }

    /**
     * id获取权限
     */
    public function getPermissionById($id)
    {
        $sql = "SELECT * FROM " . $this->mysqlConf['dbPrefix'] . "backstage.permission WHERE `id` = '$id' LIMIT 1";
        $row = $this->mysql->fetchAll($sql);
        return $row[0];
    }

    /**
     * 是否可以关闭权限
     */
    public function canClosePermissionList($id)
    {
        $sql = "SELECT count(*) as num FROM " . $this->mysqlConf['dbPrefix'] . "backstage.permission WHERE `pid` = '" . $id . "' AND `status` = '1' ORDER BY `sort` DESC";
        $row = $this->mysql->fetchAll($sql);
        if($row[0]['num'] > 0)
            return false;
        else
            return true;
    }

    /**
     * 是否可以打开权限
     */
    public function canOpenPermissionList($pid)
    {
        $sql = "SELECT count(*) as num FROM " . $this->mysqlConf['dbPrefix'] . "backstage.permission WHERE `id` = '" . $pid . "' AND `status` = '0' ORDER BY `sort` DESC";
        $row = $this->mysql->fetchAll($sql);
        if($row[0]['num'] > 0)
            return false;
        else
            return true;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}