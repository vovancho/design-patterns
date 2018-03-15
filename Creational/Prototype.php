<?php

/**
 * Created by PhpStorm.
 * User: Владимир
 * Date: 15.03.2018
 * Time: 9:24
 */

namespace Creational\Prototype;

$patternTitle = 'Прототип';

abstract class DefaultHuman
{
    protected $name = 'не задано';

    public function setName($name)
    {
        $this->name = $name;
    }

    abstract public function getDescription();
}

class DefaultPatient extends DefaultHuman
{
    public function getDescription()
    {
        return 'Пациент: ' . $this->name . PHP_EOL;
    }
}


class DefaultVrach extends DefaultHuman
{
    public function getDescription()
    {
        return 'Врач: ' . $this->name . PHP_EOL;
    }
}

class AmbKartaFactory
{
    private $patient;
    private $vrach;

    public function __construct(DefaultPatient $patient, DefaultVrach $vrach)
    {
        $this->patient = $patient;
        $this->vrach = $vrach;
    }

    public function getPatientPrototype()
    {
        return clone $this->patient;
    }

    public function getVrachPrototype()
    {
        return clone $this->vrach;
    }
}

echo $patternTitle . PHP_EOL;

$ambKartaFactory = new AmbKartaFactory(
    $defaultPatient = new DefaultPatient,
    $defaultVrach = new DefaultVrach
);

$prototypePatient = $ambKartaFactory->getPatientPrototype();
$prototypePatient->setName('Иванов Иван Иванович');
$prototypeVrach = $ambKartaFactory->getVrachPrototype();
$prototypeVrach->setName('Петров Петр Петрович');

echo $defaultPatient->getDescription();
echo $defaultVrach->getDescription();
echo '-----------------' . PHP_EOL;
echo $prototypePatient->getDescription();
echo $prototypeVrach->getDescription();

/**
 * php Creational/Prototype.php
 * Прототип
 * Пациент: не задано
 * Врач: не задано
 * -----------------
 * Пациент: Иванов Иван Иванович
 * Врач: Петров Петр Петрович
 */