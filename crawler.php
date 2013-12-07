<?php

ini_set('display_errors',1);
error_reporting(E_ALL);


chdir(dirname(__FILE__));

// Setup autoloading
require 'init_autoloader.php';
require 'functions.php';

if (isset($argv[1])) {
    $action = $argv[1];
    $filename = "scripts/".$action.".php";
    
    if (is_file($filename)) {
        include $filename;
    } else {
        print "action ".$action." is not found";
    }
}

