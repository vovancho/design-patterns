<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 8:26
 */

namespace Structural\Adapter;

$patternTitle = 'Адаптер';

interface IAmbKarta
{
    public function getFam();

    public function getIm();

    public function getOt();
}

interface IStacionarKarta
{
    public function getPatient();
}

class Patient
{
    protected $fio;

    public function __construct($fio)
    {
        $this->fio = $fio;
    }

    public function getFIO()
    {
        return $this->fio;
    }
}

class AmbKarta implements IAmbKarta
{

    private $fam;
    private $im;
    private $ot;

    public function __construct($fam, $im, $ot)
    {
        $this->fam = $fam;
        $this->im = $im;
        $this->ot = $ot;
    }

    public function getFam()
    {
        return $this->fam;
    }

    public function getIm()
    {
        return $this->im;
    }

    public function getOt()
    {
        return $this->ot;
    }
}

class StacionarKarta implements IStacionarKarta
{
    private $fio;

    public function __construct($fio)
    {
        $this->fio = $fio;
    }

    function getPatient()
    {
        return new Patient($this->fio);
    }
}

class AmbKartaAdapter implements IStacionarKarta
{
    /** @var IAmbKarta */
    protected $ambKarta;

    public function __construct(IAmbKarta $ambKarta)
    {
        $this->ambKarta = $ambKarta;
    }

    public function getPatient()
    {
        return new Patient($this->ambKarta->getFam() . ' ' . $this->ambKarta->getIm() . ' ' . $this->ambKarta->getOt());
    }
}

echo $patternTitle . PHP_EOL;

$stacionarKarta = new StacionarKarta('Иванов Иван Иванович');
echo "Стационарная карта пациента:" . PHP_EOL;
echo $stacionarKarta->getPatient()->getFIO() . PHP_EOL;

$ambKarta = new AmbKarta('Петров', 'Петр', 'Петрович');
$ambKartaToStacionarKarta = new AmbKartaAdapter($ambKarta);
echo "Стационарная карта пациента из амбулаторной карты:" . PHP_EOL;
echo $ambKartaToStacionarKarta->getPatient()->getFIO() . PHP_EOL;

/**
 * php Structural/Adapter.php
 * Адаптер
 * Стационарная карта пациента:
 * Иванов Иван Иванович
 * Стационарная карта пациента из амбулаторной карты:
 * Петров Петр Петрович
 */