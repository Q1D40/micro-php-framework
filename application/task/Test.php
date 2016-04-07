<?php

/**
 * Test
 */
class Test extends Task {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 测试
     */
    public function test()
    {
        $sql = '';
        $data = $this->mysql->fetchAll($sql);
        var_dump($data);
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}