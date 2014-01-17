<?php

ini_set('display_errors',1);
error_reporting(E_ALL);


chdir(dirname(__FILE__));

// Setup autoloading
require 'init_autoloader.php';
require 'functions.php';

if (isset($argv[1])) {
    $type = $argv[1];
    $filename = "scripts/".$type.".php";
    
    if (isset($argv[2])) {
        switch ($argv[2]) {
            case 'update':
            case 'Update':
                $flag['update'] = 1;
                if (isset($argv[3]) && is_numeric($argv[3])) {
                    $flag['num_pages'] = $argv[3];
                }
                break;
            default:
                print "action ".$argv[2]." is not recognizable";
                die;
                break;
        }
    }
    
    if (is_file($filename)) {
        include $filename;
    } else {
        print "type ".$type." is not found";
    }
}

