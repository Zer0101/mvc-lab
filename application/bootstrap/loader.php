<?php

use System\Autoload\Autoloader;
use System\Config\Autoload as AutoloadConfig;
use System\Config\Base as Config;

//Fetch custom namespaces, classmaps, files and etc.
try{
    $registeredFiles = include_once APPPATH . 'config/autoload.php';
} catch (\Exception $e){
    $registeredFiles = [];
}

//Initialize autoloader
$loader = new Autoloader(new AutoloadConfig(new Config($registeredFiles)));

//Start autoloader
$loader->register();

//Connect composer to project
require_once BASEPATH . 'vendor/autoload.php';