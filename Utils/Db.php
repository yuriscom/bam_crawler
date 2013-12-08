<?php

namespace Utils;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

class Db {

    private static $_instance;
    public $em = null;
    private $_scope = null;

    private function __construct() {
        $paths = array("Entity");
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

        $params = array(
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => "m4!x#cc8f",
            'dbname' => 'crawler',
        );

        $em = EntityManager::create($params, $config);
        $this->setEntityManager($em);
        $this->setScope("Entity");
    }

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function setEntityManager($em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        return $this->em;
    }

    public function setScope($scope) {
        $this->_scope = $scope;
    }

    public function getScope() {
        return $this->_scope;
    }

    public function getTable($table) {
        if (!is_object($this->em)) {
            throw new Exception("Entity Manager is not set");
        }

        $repository = ($this->_scope ? $this->_scope . "\\" : "") . $table;

        return $this->em->getRepository($repository);
    }

}