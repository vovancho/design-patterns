<?php

/**
 * Created by PhpStorm.
 * User: Владимир
 * Date: 14.03.2018
 * Time: 20:03
 */

namespace Creational\Singleton;

$patternTitle = 'Синглтон';

class Poliklinika
{
    private static $instance;  // экземпляр объекта

    private function __construct()
    {
    }  // Защищаем от создания через new Singleton

    private function __clone()
    {
    }  // Защищаем от создания через клонирование

    private function __wakeup()
    {
    }  // Защищаем от создания через unserialize

    public static function getInstance()
    {    // Возвращает единственный экземпляр класса. @return Singleton
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function name()
    {
        return 'Поликлиника №1' . PHP_EOL;
    }
}

echo $patternTitle . PHP_EOL;

echo Poliklinika::getInstance()->name();

/**
 * php Creational/Singleton.php
 * Синглтон
 * Поликлиника №1
 */