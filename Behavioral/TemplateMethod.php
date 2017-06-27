<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 19:29
 */
namespace Behavioral\TemplateMethod;

$patternTitle = 'шаблонный метод';

abstract class BaseObsledovanie
{
    private $patientFIO;
    protected $complaints = [];

    public function __construct($patientFIO)
    {
        $this->patientFIO = $patientFIO;
    }

    final public function perform() // Шаблонный метод
    {
        $this->visitNevrolog();
        $this->visitKardiolog();
        echo $this->getComplaints();
    }

    abstract function visitNevrolog();

    abstract function visitKardiolog();

    public function getComplaints()
    {
        return "У пациента {$this->patientFIO} умеются жалобы: " . PHP_EOL
        . implode(PHP_EOL, $this->complaints) . PHP_EOL;
    }
}

class Patient extends BaseObsledovanie
{
    public function visitNevrolog()
    {
        $this->complaints[] = 'Болит голова';
    }

    public function visitKardiolog()
    {
        $this->complaints[] = 'Болит сердце';
    }
}

echo $patternTitle . PHP_EOL;

$patient = new Patient('Иванов Иван Иванович');
$patient->perform();