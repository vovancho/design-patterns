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
    public function __construct(private string $fio)
    {
    }

    public function giveAmbKarta(string $doctorName): void
    {
        echo "Пациент '{$this->fio}' передает амбулаторную карту врачу '{$doctorName}'." . PHP_EOL;
    }

    public function takeAmbKarta(): void
    {
        echo "Пациент '{$this->fio}' забирает амбулаторную карту у врача." . PHP_EOL;
    }
}

interface AmbKartaCommandInterface // Интерфейс всех команд
{
    public function executeOperation(): void;
}

class GiveAmbKarta implements AmbKartaCommandInterface // Конкретная команда.
{
    public function __construct(private Patient $patient, private string $doctorName)
    {
    }

    public function executeOperation(): void
    {
        $this->patient->giveAmbKarta($this->doctorName);
    }
}

class TakeAmbKarta implements AmbKartaCommandInterface // Конкретная команда.
{
    public function __construct(private Patient $patient)
    {
    }

    public function executeOperation(): void
    {
        $this->patient->takeAmbKarta();
    }
}

class Doctor //  Invoker (Командир)
{
    public function execute(AmbKartaCommandInterface $ambKartaCommand): void
    {
        $ambKartaCommand->executeOperation();
    }
}

echo $patternTitle . PHP_EOL . PHP_EOL;

$patient = new Patient('Иванов Иван Иванович');

$doctor = new Doctor();
$doctor->execute(new GiveAmbKarta($patient, 'Сидоров Сергей Петрович'));
$doctor->execute(new TakeAmbKarta($patient));

/**
 * php Behavioral/Command.php
 *
 * Команда
 *
 * Пациент 'Иванов Иван Иванович' передает амбулаторную карту врачу 'Сидоров Сергей Петрович'.
 * Пациент 'Иванов Иван Иванович' забирает амбулаторную карту у врача.
 */
