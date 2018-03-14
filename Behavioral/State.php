<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 12:58
 */

namespace Behavioral\State;

$patternTitle = 'Состояние';

abstract class BasePatient
{
    const ENTERED = 'Поступил';
    const TREATED = 'Лечится';
    const RECOVERED = 'Выздоровел';
    const HEALTHY = 'Здоров';

    private $status;
    /** @var BasePatient */
    protected static $state;

    abstract protected function done();

    protected function setStatus($status)
    {
        $this->status = $status;
    }

    protected function getStatus()
    {
        return $this->status;
    }
}

class Patient extends BasePatient
{

    public function getState()
    {
        return static::$state;
    }

    public function setState(BasePatient $state)
    {
        static::$state = $state;
    }


    public function done()
    {
        static::$state->done();
    }

    public function getStatus()
    {
        return static::$state->getStatus();
    }
}

class PatientEnteredSick extends BasePatient
{
    public function __construct()
    {
        $this->setStatus(self::ENTERED);
    }

    protected function done()
    {
        static::$state = new PatientTreated();
    }
}

class PatientEnteredHealthy extends BasePatient
{
    public function __construct()
    {
        $this->setStatus(self::ENTERED);
    }

    protected function done()
    {
        $this->setStatus(self::HEALTHY);
    }
}

class PatientTreated extends BasePatient
{

    public function __construct()
    {
        $this->setStatus(self::TREATED);
    }

    protected function done()
    {
        $this->setStatus(self::RECOVERED);
    }
}

echo $patternTitle . PHP_EOL;

$patient1 = new Patient();
$patient1->setState(new PatientEnteredSick());
echo '1. Состояние пациента 1: ' . $patient1->getStatus() . PHP_EOL;
$patient1->done();
echo '2. Состояние пациента 1: ' . $patient1->getStatus() . PHP_EOL;
$patient1->done();
echo '3. Состояние пациента 1: ' . $patient1->getStatus() . PHP_EOL;

$patient2 = new Patient();
$patient2->setState(new PatientEnteredHealthy());
echo '1. Состояние пациента 2: ' . $patient2->getStatus() . PHP_EOL;
$patient2->done();
echo '2. Состояние пациента 2: ' . $patient2->getStatus() . PHP_EOL;

/**
 * php Behavioral/State.php
 * Состояние
 * 1. Состояние пациента 1: Поступил
 * 2. Состояние пациента 1: Лечится
 * 3. Состояние пациента 1: Выздоровел
 * 1. Состояние пациента 2: Поступил
 * 2. Состояние пациента 2: Здоров
 */