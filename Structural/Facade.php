<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 14:00
 */
namespace Structural\Facade;

$patternTitle = 'Фасад';

interface IPatient
{
    public function setFio($fio);

    public function getFio();

    public function setSex($sex);

    public function getSex();
}

interface IKarta
{
    public function setPatient(IPatient $patient);

    public function setType($type);

    public function getType();
}

class Patient implements IPatient
{
    private $fio;
    private $sex;

    public function setFio($fio)
    {
        $this->fio = $fio;
    }

    public function getFio()
    {
        return $this->fio;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    public function getSex()
    {
        return $this->sex;
    }
}

class Karta implements IKarta
{
    private $patient;
    private $type;

    public function setPatient(IPatient $patient)
    {
        $this->patient = $patient;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}

class AmbKartaFacade
{
    private $patient;
    private $karta;

    public function __construct(IPatient $patient, IKarta $karta)
    {
        $this->patient = $patient;
        $this->karta = $karta;
    }

    public function fillKarta()
    {
        $this->patient->setFio('Иванов Иван Иванович');
        $this->patient->setSex('Мужчина');
        $this->karta->setPatient($this->patient);
        $this->karta->setType('Амбулаторная');
    }

    public function getData()
    {
        return "Тип карты: {$this->karta->getType()}" . PHP_EOL
        . "Пациент: {$this->patient->getFio()}" . PHP_EOL
        . "Пол: {$this->patient->getSex()}" . PHP_EOL;
    }
}

echo $patternTitle . PHP_EOL;

$ambKarta = new AmbKartaFacade(new Patient(), new Karta());
$ambKarta->fillKarta();
echo $ambKarta->getData();