<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 28.06.2017
 * Time: 16:08
 */
namespace Behavioral\Command;

$patternTitle = 'Команда';

class Patient // Receiver (Исполнитель)
{
    private $fio;

    public function __construct($fio)
    {
        $this->fio = $fio;
    }

    public function giveAmbKarta()
    {
        echo "Пациент '{$this->fio}' передает амбулаторную карту врачу." . PHP_EOL;
    }

    public function takeAmbKarta()
    {
        echo "Пациент '{$this->fio}' забирает амбулаторную карту у врача." . PHP_EOL;
    }
}

interface IAmbKartaCommand // Интерфейс всех команд
{
    public function executeOperation();
}

class GiveAmbKarta implements IAmbKartaCommand // Конкретная команда.
{
    private $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function executeOperation()
    {
        $this->patient->giveAmbKarta();
    }
}

class TakeAmbKarta implements IAmbKartaCommand // Конкретная команда.
{
    private $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function executeOperation()
    {
        $this->patient->takeAmbKarta();
    }
}

class Doctor //  Invoker (Командир)
{
    public function execute(IAmbKartaCommand $ambKartaCommand)
    {
        $ambKartaCommand->executeOperation();
    }
}

echo $patternTitle . PHP_EOL;

$patient = new Patient('Иванов Иван Иванович');

$doctorTakeAmbKartaCommand = new GiveAmbKarta($patient);
$doctorGiveAmbKartaCommand = new TakeAmbKarta($patient);

$doctor = new Doctor();
$doctor->execute($doctorTakeAmbKartaCommand);
$doctor->execute($doctorGiveAmbKartaCommand);