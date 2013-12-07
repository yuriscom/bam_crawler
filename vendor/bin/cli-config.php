<?php

 use Doctrine\ORM\Tools\Setup;

use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once dirname(__FILE__)."/../autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations

$isDevMode = true;

$paths = array(dirname(dirname(__DIR__))."/Entity");

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);


// database configuration parameters

$conn = array(

           'driver' => 'pdo_mysql',

           'user' => 'root',

           'password' => "m4!x#cc8f",

           'dbname' => 'crawler',

       );

// obtaining the entity manager

$em = EntityManager::create($conn, $config);

/** @var $em \Doctrine\ORM\EntityManager */

$platform = $em->getConnection()->getDatabasePlatform();

$platform->registerDoctrineTypeMapping('enum', 'string');

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(

   'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),

   'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em),

   'dialog' => new \Symfony\Component\Console\Helper\DialogHelper()

));

return $helperSet;
