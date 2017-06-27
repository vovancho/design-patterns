<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 26.06.2017
 * Time: 15:19
 */
namespace Creational\BuilderK;

$patternTitle = 'Строитель';

interface IMedObsledovanieBuilder
{
    public function setPatient();

    public function setVrach();

    /**
     * @return IZakluchenie
     */
    public function getZakluchenie();
}

class Obsledovanie
{
    private $builder;

    public function __construct(IMedObsledovanieBuilder $builder)
    {
        $builder->setPatient();
        $builder->setVrach();

        $this->builder = $builder;
    }

    public function result()
    {
        return $this->builder->getZakluchenie()->result();
    }
}

interface IZakluchenie
{
    public function result();
}

class ZakluchenieNevrologa implements IZakluchenie
{
    public $patient;
    public $vrach;

    public function result()
    {
        return "Пациент: {$this->patient} " . PHP_EOL
        . " Вы посетили врача-невролога '{$this->vrach}'" . PHP_EOL;
    }
}

class ZakluchenieKardiologa implements IZakluchenie
{
    public $patient;
    public $vrach;

    public function result()
    {
        return "Пациент: {$this->patient} " . PHP_EOL
        . " Вы посетили врача-кардиолога '{$this->vrach}'" . PHP_EOL;
    }
}

class Nevrolog implements IMedObsledovanieBuilder
{
    /** @var ZakluchenieNevrologa */
    private $zakluchenie;


    public function __construct()
    {
        $this->zakluchenie = new ZakluchenieNevrologa();
    }

    public function setPatient()
    {
        $this->zakluchenie->patient = 'Петров Петр Петрович';
    }

    public function setVrach()
    {
        $this->zakluchenie->vrach = 'Иванов Иван Иванович';
    }

    public function getZakluchenie()
    {
        return $this->zakluchenie;
    }
}

class Kardiolog implements IMedObsledovanieBuilder
{
    /** @var ZakluchenieKardiologa */
    private $zakluchenie;

    public function __construct()
    {
        $this->zakluchenie = new ZakluchenieKardiologa();
    }


    public function setPatient()
    {
        $this->zakluchenie->patient = 'Бобров Сергей Иванович';
    }

    public function setVrach()
    {
        $this->zakluchenie->vrach = 'Сидоров Петр Петрович';
    }

    public function getZakluchenie()
    {
        return $this->zakluchenie;
    }
}

echo $patternTitle . PHP_EOL;

$zaklucheniePatient1 = new Obsledovanie(new Nevrolog());
echo $zaklucheniePatient1->result();

$zaklucheniePatient2 = new Obsledovanie(new Kardiolog());
echo $zaklucheniePatient2->result();