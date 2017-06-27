<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 9:50
 */
namespace Structural\Bridge;

$patternTitle = 'Мост';

interface IPatientOutput
{
    public function output($fam, $im, $ot);
}

class AmbKartaOutput implements IPatientOutput
{
    public function output($fam, $im, $ot)
    {
        return [$fam, $im, $ot];
    }
}

class StacionarKartaOutput implements IPatientOutput
{
    public function output($fam, $im, $ot)
    {
        return [$fam . ' ' . $im . ' ' . $ot];
    }
}

abstract class BasePatient
{
    /** @var  IPatientOutput */
    protected $patient;

    public function __construct(IPatientOutput $output)
    {
        $this->patient = $output;
    }

    abstract public function fio($fam, $im, $ot);
}

class Patient extends BasePatient
{
    public function fio($fam, $im, $ot)
    {
        return $this->patient->output($fam, $im, $ot); // Мост между ФИО пациента и типом ее вывода
    }
}

echo $patternTitle . PHP_EOL;

$outputAmbKarta = new AmbKartaOutput();
$outputStacionar = new StacionarKartaOutput();

$patientAmbKarta = new Patient($outputAmbKarta);
$patientStacionar = new Patient($outputStacionar);

list($fam, $im, $ot) = $patientAmbKarta->fio('Иванов', 'Иван', 'Иванович');
echo "Амбулаторная карта пациента: $fam $im $ot" . PHP_EOL;

list($fio) = $patientStacionar->fio('Петров', 'Петр', 'Петрович');
echo "Стационарная карта пациента: $fio" . PHP_EOL;