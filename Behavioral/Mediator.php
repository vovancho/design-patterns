<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 28.06.2017
 * Time: 17:24
 */

namespace Behavioral\Mediator;

$patternTitle = 'Посредник';

interface AmbKartaMediatorInterface // Общий интерфейс посредников.
{
    public function notify(object $sender, string $event): string;
}

class AmbKartaMediator implements AmbKartaMediatorInterface // Конкретный посредник
{
    public function __construct(private Patient $patient, private Doctor $doctor, private AmbKarta $ambKarta)
    {
        $this->patient->setMediator($this);
        $this->doctor->setMediator($this);
        $this->ambKarta->setMediator($this);
    }

    public function notify(object $sender, string $event): string // С другого конца, посредник должен вызывать методы нужного компонента, когда получает оповещение
    {
        return match (true) {
            $sender instanceof AmbKarta && $event === 'AmbKarta::getRecord' => "Выписка из амбулаторной карты №{$this->ambKarta->getNum()}:\nПациент '{$this->patient->fio()}' посетил врача '{$this->doctor->fio()}'",
            $sender instanceof Patient && $event === 'Patient::getState' => "Пациент посетил врача: {$this->doctor->fio()}",
            $sender instanceof Doctor && $event === 'Doctor::getVisit' => "Врач принял пациента: {$this->patient->fio()}"
        };
    }
}

abstract class BaseColleague // Общий класс коллег посредника
{
    protected ?AmbKartaMediatorInterface $mediator = null;

    public function setMediator(AmbKartaMediatorInterface $mediator)
    {
        $this->mediator = $mediator;
    }
}

class AmbKarta extends BaseColleague // Коллега/Компонент
{
    public function __construct(private int $num)
    {
    }

    public function getNum(): int
    {
        return $this->num;
    }

    public function getRecord(): string // метод оповещения посредника
    {
        return $this->mediator->notify($this, 'AmbKarta::getRecord');
    }
}

class Patient extends BaseColleague // Коллега/Компонент
{
    public function __construct(private string $patientFIO)
    {
    }

    public function fio(): string
    {
        return $this->patientFIO;
    }

    public function getState(): string // метод оповещения посредника
    {
        return $this->mediator->notify($this, 'Patient::getState');
    }
}

class Doctor extends BaseColleague // Коллега/Компонент
{
    public function __construct(private string $doctorFIO)
    {
    }

    public function fio(): string
    {
        return $this->doctorFIO;
    }

    public function getVisit(): string // метод оповещения посредника
    {
        return $this->mediator->notify($this, 'Doctor::getVisit');
    }
}

echo $patternTitle . PHP_EOL . PHP_EOL;

$patient = new Patient('Иванов Иван Иванович'); // Коллега/Компонент
$doctor = new Doctor('Ефимов Ефим Ефимович'); // Коллега/Компонент
$ambKarta = new AmbKarta(1); // Коллега/Компонент

new AmbKartaMediator($patient, $doctor, $ambKarta); // Посредник между компонентами Patient, Doctor, AmbKarta

echo $patient->getState(); // метод оповещения посредника
echo PHP_EOL . PHP_EOL;
echo $doctor->getVisit(); // метод оповещения посредника
echo PHP_EOL . PHP_EOL;
echo $ambKarta->getRecord(); // метод оповещения посредника

/**
 * php Behavioral/Mediator.php
 *
 * Посредник
 *
 * Пациент посетил врача: Ефимов Ефим Ефимович
 *
 * Врач принял пациента: Иванов Иван Иванович
 *
 * Выписка из амбулаторной карты №1:
 * Пациент 'Иванов Иван Иванович' посетил врача 'Ефимов Ефим Ефимович'
 *
 */
