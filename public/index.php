<?php

define("FCPATH" , realpath(__DIR__) . '/');
define("BASEPATH", dirname(FCPATH) . '/');
define("APPPATH", BASEPATH . 'application/');
define("SYSPATH", BASEPATH . 'system/');

try {
    require_once SYSPATH . 'bootstrap.php';
    require_once APPPATH . 'bootstrap/loader.php';

} catch (\Exception $e) {
    echo $e->getMessage();
}