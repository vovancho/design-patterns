<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 17:45
 */

namespace Structural\Composite;

$patternTitle = 'Компоновщик';

interface IOutput
{
    public function render();
}

class Doctor implements IOutput
{
    private $doctorFIO;

    public function __construct($doctorFIO)
    {
        $this->doctorFIO = $doctorFIO;
    }

    public function render()
    {
        echo "Пациента осмотрел врач: {$this->doctorFIO}" . PHP_EOL;
    }
}

class AmbKarta implements IOutput
{
    private $patientFIO;
    private $doctors = [];

    public function __construct($patientFIO)
    {
        $this->patientFIO = $patientFIO;
    }

    public function render()
    {
        echo $karta = '---Амбулаторная карта---' . PHP_EOL;

        /** @var IOutput $doctor */
        foreach ($this->doctors as $doctor) {
            echo $doctor->render() . PHP_EOL;
        }

        echo $karta = '------------------------' . PHP_EOL;
    }

    public function addOsmotr(IOutput $doctor)
    {
        $this->doctors[] = $doctor;
    }
}

class Report implements IOutput
{
    private $karts = [];

    public function render()
    {
        echo 'Отчет на дату: ' . date('d.m.Y') . PHP_EOL . PHP_EOL;

        /** @var IOutput $doctor */
        foreach ($this->karts as $karta) {
            echo $karta->render() . PHP_EOL;
        }
    }

    public function addKarta(IOutput $karta)
    {
        $this->karts[] = $karta;
    }
}

echo $patternTitle . PHP_EOL;

$patientAmbKarta1 = new AmbKarta('Иванов Иван Иванович');
$patientAmbKarta1->addOsmotr(new Doctor('Сидоров Николай Николаевич'));
$patientAmbKarta1->addOsmotr(new Doctor('Гоголь Мария Ивановна'));

$patientAmbKarta2 = new AmbKarta('Петров Петр Петрович');
$patientAmbKarta2->addOsmotr(new Doctor('Фоменко Николай Сергеевич'));

$report = new Report();
$report->addKarta($patientAmbKarta1);
$report->addKarta($patientAmbKarta2);
$report->render();

/**
 * php Structural/Composite.php
 * Компоновщик
 * Отчет на дату: 14.03.2018
 *
 * ---Амбулаторная карта---
 * Пациента осмотрел врач: Сидоров Николай Николаевич
 * Пациента осмотрел врач: Гоголь Мария Ивановна
 * ------------------------
 *
 * ---Амбулаторная карта---
 * Пациента осмотрел врач: Фоменко Николай Сергеевич
 * ------------------------
 */