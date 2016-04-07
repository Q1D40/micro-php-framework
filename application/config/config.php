<?php

/**
 * mysql
 */
$config['mysql']['host'] = '127.0.0.1';
$config['mysql']['port'] = '3306';
$config['mysql']['user'] = 'root';
$config['mysql']['password'] = '12345';
$config['mysql']['dbPrefix'] = 'sx_';
$config['mysql']['db'] = 'backstage';

/**
 * cron
 */
$config['group'][1][1]['class'] = 'Test';
$config['group'][1][1]['method'] = 'test';

/**
 * route
 */
$config['route']['default'] = 'user/welcome';

$configDevFile = dirname(__FILE__) . '/config_dev.php';
if(file_exists($configDevFile))
    include_once($configDevFile);

return $config;
