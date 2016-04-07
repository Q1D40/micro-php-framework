<?php

include_once(dirname(__FILE__) . '/framework/Cron.php');

/**
 * start process
 */
Cron::getSingleton()->process();