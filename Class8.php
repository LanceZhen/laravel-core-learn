<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/15
 * Time: 10:48
 */
trait Singleton {
    protected static $_instance;

    final public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new static();
        }

        return self::$_instance;
    }

    private function __construct() {
        $this->init();
    }

    protected function init() {
        echo 'singleton init ..';
    }

}

class Db {
    use Singleton;
    protected function init() {
        echo 'db init ..';
    }
}

$db = Db::getInstance();
print_r($db);
