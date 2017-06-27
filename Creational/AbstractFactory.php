<?php

/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 26.06.2017
 * Time: 16:46
 */
namespace Creational\AbstractFactory;

$patternTitle = 'Абстрактная фабрика';

abstract class AbstractFactory
{
    abstract public function createPatient($fio);

    abstract public function createZakluchenie($vrach);
}

class NevrologFactory extends AbstractFactory
{
    public function createPatient($fio)
    {
        return new PatientNevrologa($fio);
    }

    public function createZakluchenie($vrach)
    {
        return new ZakluchenieNevrologa($vrach);
    }
}

class KardiologFactory extends AbstractFactory
{
    public function createPatient($fio)
    {
        return new PatientKardiologa($fio);
    }

    public function createZakluchenie($vrach)
    {
        return new ZakluchenieKardiologa($vrach);
    }
}

interface IZakluchenie
{
    public function __construct($vrach);

    public function result();
}

class ZakluchenieNevrologa implements IZakluchenie
{
    protected $vrach;

    public function __construct($vrach)
    {
        $this->vrach = $vrach;
    }

    public function result()
    {
        return "Вы посетили врача-невролога '{$this->vrach}'" . PHP_EOL;
    }
}

class ZakluchenieKardiologa implements IZakluchenie
{
    protected $vrach;

    public function __construct($vrach)
    {
        $this->vrach = $vrach;
    }

    public function result()
    {
        return "Вы посетили врача-кардиолога '{$this->vrach}'" . PHP_EOL;
    }
}

abstract class Patient
{
    protected $fio;

    public function __construct($fio)
    {
        $this->fio = $fio;
    }

    abstract public function fio();
}

class PatientNevrologa extends Patient
{
    public function fio()
    {
        return 'Пациент неврлога: ' . $this->fio . PHP_EOL;
    }
}

class PatientKardiologa extends Patient
{
    public function fio()
    {
        return 'Пациент кардиолога: ' . $this->fio . PHP_EOL;
    }
}

echo $patternTitle . PHP_EOL;

$factoryNevrolog = new NevrologFactory();
$patient1 = $factoryNevrolog->createPatient('Петров Петр Петрович');
$zakluchenie1 = $factoryNevrolog->createZakluchenie('Иванов Иван Иванович');
echo $patient1->fio();
echo $zakluchenie1->result();

$factoryKardiolog = new KardiologFactory();
$patient2 = $factoryKardiolog->createPatient('Бобров Сергей Иванович');
$zakluchenie2 = $factoryKardiolog->createZakluchenie('Сидоров Петр Петрович');
echo $patient2->fio();
echo $zakluchenie2->result();