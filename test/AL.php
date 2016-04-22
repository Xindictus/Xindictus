<?php
/**
 * Created by PhpStorm.
 * User: Xindictus
 * Date: 13/4/2016
 * Time: 12:04
 */

namespace test;


class AL{

    function __autoload($class){
        $parts = explode('\\', $class);
        require end($parts) . '.php';
    }

}