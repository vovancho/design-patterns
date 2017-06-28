<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 28.06.2017
 * Time: 17:24
 */
namespace Behavioral\Mediator;

$patternTitle = 'Посредник';

interface IAmbKartaMediator // Общий интерфейс посредников.
{
    public function currentRecord();
}

class AmbKartaMediator implements IAmbKartaMediator // Конкретный посредник
{
    private $patient;
    private $doctor;
    private $ambKarta;

    public function __construct(Patient $patient, Doctor $doctor, AmbKarta $ambKarta)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->ambKarta = $ambKarta;
        $this->patient->setMediator($this);
        $this->doctor->setMediator($this);
        $this->ambKarta->setMediator($this);
    }

    public function currentRecord() // С другого конца, посредник должен вызывать методы нужного компонента, когда получает оповещение
    {
        return "Выписка из амбулаторной карты №{$this->ambKarta->getNum()}:" . PHP_EOL
        . "Пациент '{$this->patient->fio()}' посетил врача '{$this->doctor->fio()}'";
    }
}

abstract class Colleague // Общий класс коллег посредника
{
    /** @var IAmbKartaMediator */
    protected $mediator;

    public function setMediator(IAmbKartaMediator $mediator)
    {
        $this->mediator = $mediator;
    }
}

class AmbKarta extends Colleague // Коллега/Компонент
{
    private $num;

    public function __construct($num)
    {
        $this->num = $num;
    }

    public function getNum()
    {
        return $this->num;
    }

    public function getRecord() // метод оповещения посредника
    {
        echo $this->mediator->currentRecord();
    }
}

class Patient extends Colleague // Коллега/Компонент
{
    private $patientFIO;

    public function __construct($patientFIO)
    {
        $this->patientFIO = $patientFIO;
    }

    public function fio()
    {
        return $this->patientFIO;
    }
}

class Doctor extends Colleague // Коллега/Компонент
{
    private $doctorFIO;

    public function __construct($doctorFIO)
    {
        $this->doctorFIO = $doctorFIO;
    }

    public function fio()
    {
        return $this->doctorFIO;
    }
}

echo $patternTitle . PHP_EOL;

$patient = new Patient('Иванов Иван Иванович'); // Коллега/Компонент
$doctor = new Doctor('Ефимов Ефим Ефимович'); // Коллега/Компонент
$ambKarta = new AmbKarta(1); // Коллега/Компонент

new AmbKartaMediator($patient, $doctor, $ambKarta); // Посредник между компонентами Patient, Doctor, AmbKarta

$ambKarta->getRecord(); // метод оповещения посредника