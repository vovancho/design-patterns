<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 26.06.2017
 * Time: 19:17
 */

namespace Creational\FactoryMethod;

$patternTitle = 'Фабричный метод';

abstract class FactoryMethod
{
    abstract protected function createObsledovanie($patient, $vrach);

    /**
     * @param $patient
     * @param $vrach
     * @return IZakluchenie
     */
    public function create($patient, $vrach)
    {
        return $this->createObsledovanie($patient, $vrach);
    }
}

class NevrologFactory extends FactoryMethod
{
    protected function createObsledovanie($patient, $vrach)
    {
        return new ZakluchenieNevrologa($patient, $vrach);
    }
}

class KardiologFactory extends FactoryMethod
{
    protected function createObsledovanie($patient, $vrach)
    {
        return new ZakluchenieKardiologa($patient, $vrach);
    }
}

interface IZakluchenie
{
    public function result();
}

class ZakluchenieNevrologa implements IZakluchenie
{
    protected $patient;
    protected $vrach;

    public function __construct($patient, $vrach)
    {
        $this->patient = $patient;
        $this->vrach = $vrach;
    }

    public function result()
    {
        return "Пациент: {$this->patient} " . PHP_EOL
            . "Вы посетили врача-невролога '{$this->vrach}'" . PHP_EOL;
    }
}

class ZakluchenieKardiologa implements IZakluchenie
{
    protected $patient;
    protected $vrach;

    public function __construct($patient, $vrach)
    {
        $this->patient = $patient;
        $this->vrach = $vrach;
    }

    public function result()
    {
        return "Пациент: {$this->patient} " . PHP_EOL
            . "Вы посетили врача-кардиолога '{$this->vrach}'" . PHP_EOL;
    }
}

echo $patternTitle . PHP_EOL;

$obsledovanieNevrolog = new NevrologFactory();
$zakluchenieNevrolog = $obsledovanieNevrolog->create('Петров Петр Петрович', 'Иванов Иван Иванович');
echo $zakluchenieNevrolog->result();

$obsledovanieKardiolog = new KardiologFactory();
$zakluchenieKardiolog = $obsledovanieKardiolog->create('Бобров Сергей Иванович', 'Сидоров Петр Петрович');
echo $zakluchenieKardiolog->result();

/**
 * php Creational/FactoryMethod.php
 * Фабричный метод
 * Пациент: Петров Петр Петрович
 * Вы посетили врача-невролога 'Иванов Иван Иванович'
 * Пациент: Бобров Сергей Иванович
 * Вы посетили врача-кардиолога 'Сидоров Петр Петрович'
 */