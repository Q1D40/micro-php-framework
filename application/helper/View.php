<?php

/**
 * View
 */
class View {

    /**
     * construct
     */
    public function __construct()
    {
        // TODO
    }

    /**
     * topMenu
     */
    public static function topMenu($permission)
    {
        $menu = self::getMenuByPid($permission, 0);
        foreach($menu as $key1 => $row1){
            $arr1 = self::getMenuByPid($permission, $row1['id']);
            $menu[$key1]['sub'] = $arr1;
        }
        return $menu;
    }

    /**
     * leftMenu
     */
    public static function leftMenu($permission, $url)
    {
        $m4 = array();
        foreach($permission as $row){
            if($row['level'] == 4 && $row['url'] == $url){
                $m4 = $row;
                break;
            }
        }
        $m3 = self::getMenuByid($permission, @$m4['pid']);
        $m2 = self::getMenuByid($permission, @$m3['pid']);
        $menu = self::getMenuByPid($permission, $m2['id']);
        foreach($menu as $key1 => $row1){
            $arr1 = self::getMenuByPid($permission, $row1['id']);
            $menu[$key1]['sub'] = $arr1;
        }
        return $menu;
    }

    /**
     * menuLine
     */
    public static function menuLine($permission, $url)
    {
        $arr = array();
        foreach($permission as $row){
            if($row['level'] == 4 && $row['url'] == $url){
                $arr['m4'] = $row;
                break;
            }
        }
        $arr['m3'] = self::getMenuByid($permission, @$arr['m4']['pid']);
        $arr['m2'] = self::getMenuByid($permission, @$arr['m3']['pid']);
        $arr['m1'] = self::getMenuByid($permission, @$arr['m2']['pid']);
        return $arr;
    }

    /**
     * getMenuByPid
     */
    private static function getMenuByPid($permissionList, $pid)
    {
        $arr = array();
        foreach($permissionList as $row){
            if($row['pid'] == $pid)
                $arr[] = $row;
        }
        return $arr;
    }

    /**
     * getMenuByid
     */
    private static function getMenuByid($permissionList, $id)
    {
        $arr = array();
        foreach($permissionList as $row){
            if($row['id'] == $id) {
                $arr = $row;
                break;
            }
        }
        return $arr;
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        // TODO
    }
}