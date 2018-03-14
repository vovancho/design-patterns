<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 10:37
 */

namespace Behavioral\Strategy;

$patternTitle = 'Стратегия';

interface OutputStrategy
{
    public function output($fam, $im, $ot);
}

class AmbKartaStrategy implements OutputStrategy
{

    public function output($fam, $im, $ot)
    {
        return [$fam, $im, $ot];
    }
}


class StacionarKartaStrategy implements OutputStrategy
{

    public function output($fam, $im, $ot)
    {
        return [$fam . ' ' . $im . ' ' . $ot];
    }
}

class Patient
{
    /** @var OutputStrategy */
    protected $strategy;

    public function setStrategy(OutputStrategy $outputStrategy)
    {
        $this->strategy = $outputStrategy;
    }

    public function fio($fam, $im, $ot)
    {
        return $this->strategy->output($fam, $im, $ot);
    }
}

echo $patternTitle . PHP_EOL;

$outputAmbKarta = new AmbKartaStrategy();
$outputStacionar = new StacionarKartaStrategy();

$patientAmbKarta = new Patient();
$patientAmbKarta->setStrategy($outputAmbKarta);
$patientStacionar = new Patient();
$patientStacionar->setStrategy($outputStacionar);

list($fam, $im, $ot) = $patientAmbKarta->fio('Иванов', 'Иван', 'Иванович');
echo "Амбулаторная карта пациента: $fam $im $ot" . PHP_EOL;

list($fio) = $patientStacionar->fio('Петров', 'Петр', 'Петрович');
echo "Стационарная карта пациента: $fio" . PHP_EOL;

/**
 * php Behavioral/Strategy.php
 * Стратегия
 * Амбулаторная карта пациента: Иванов Иван Иванович
 * Стационарная карта пациента: Петров Петр Петрович
 */