<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 12:58
 */

namespace Behavioral\State;

$patternTitle = 'Состояние';

class Patient // Контекст определяет интерфейс, представляющий интерес для клиентов. Он также хранит ссылку на экземпляр подкласса Состояния, который отображает текущее состояние Контекста
{
    private PatientState $state; // Ссылка на текущее состояние Контекста

    public function __construct(PatientState $state)
    {
        $this->transitionTo($state);
    }

    public function transitionTo(PatientState $state): void // Контекст позволяет изменять объект Состояния во время выполнения
    {
        $this->state = $state;
        $this->state->setContext($this);
    }

    public function toHeal(): void // Контекст делегирует часть своего поведения текущему объекту Состояния
    {
        $this->state->healing();
    }

    public function isRecovered(): bool // Контекст делегирует часть своего поведения текущему объекту Состояния
    {
        return $this->state->isRecovered();
    }
}

abstract class PatientState // Базовый класс Состояния объявляет методы, которые должны реализовать все Конкретные Состояния, а также предоставляет обратную ссылку на объект Контекст, связанный с Состоянием
{                           // Эта обратная ссылка может использоваться Состояниями для передачи Контекста другому Состоянию
    protected ?Patient $patient = null;

    public function setContext(Patient $patient): void
    {
        $this->patient = $patient;
    }

    abstract public function healing(): void;

    abstract public function isRecovered(): bool;
}

class EnteredPatientState extends PatientState // Конкретные Состояния реализуют различные модели поведения, связанные с состоянием Контекста
{
    public function healing(): void
    {
        $this->patient->transitionTo(new TreatedPatientState());
    }

    public function isRecovered(): bool
    {
        return false;
    }
}

class TreatedPatientState extends PatientState // Конкретные Состояния реализуют различные модели поведения, связанные с состоянием Контекста
{
    public function healing(): void
    {
        $this->patient->transitionTo(new HealthyPatientState());
    }

    public function isRecovered(): bool
    {
        return false;
    }
}

class HealthyPatientState extends PatientState // Конкретные Состояния реализуют различные модели поведения, связанные с состоянием Контекста
{
    public function healing(): void
    {
    }

    public function isRecovered(): bool
    {
        return true;
    }
}

echo $patternTitle . PHP_EOL . PHP_EOL;

$patient1 = new Patient(new EnteredPatientState());
echo 'Здоровье пациента 1: ' . ($patient1->isRecovered() ? 'Здоров' : 'Не здоров') . PHP_EOL;
$patient1->toHeal();
echo 'Здоровье пациента 1: ' . ($patient1->isRecovered() ? 'Здоров' : 'Не здоров') . PHP_EOL;
$patient1->toHeal();
echo 'Здоровье пациента 1: ' . ($patient1->isRecovered() ? 'Здоров' : 'Не здоров') . PHP_EOL;

echo PHP_EOL;

$patient2 = new Patient(new TreatedPatientState());
echo 'Здоровье пациента 2: ' . ($patient2->isRecovered() ? 'Здоров' : 'Не здоров') . PHP_EOL;
$patient2->toHeal();
echo 'Здоровье пациента 2: ' . ($patient2->isRecovered() ? 'Здоров' : 'Не здоров') . PHP_EOL;

/**
 * php Behavioral/State.php
 *
 * Состояние
 *
 * Здоровье пациента 1: Не здоров
 * Здоровье пациента 1: Не здоров
 * Здоровье пациента 1: Здоров
 *
 * Здоровье пациента 2: Не здоров
 * Здоровье пациента 2: Здоров
 */
