<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 28.06.2017
 * Time: 8:26
 */
namespace Structural\Decorator;

$patternTitle = 'Декоратор';

interface IOutput // Общий интерфейс компонентов.
{
    public function render();
}

class AmbKarta implements IOutput // Один из конкретных компонент, реализует базовую функциональность.
{

    private $fio;

    public function __construct($fio)
    {
        $this->fio = $fio;
    }

    public function render()
    {
        return "Пациент: {$this->fio}" . PHP_EOL;
    }
}

abstract class OutputParentDecorator implements IOutput // Родитель всех Декораторов содержит код обёртывания.
{
    protected $wrapped;

    public function __construct(IOutput $record)
    {
        $this->wrapped = $record;
    }
}

class DoctorDecorator extends OutputParentDecorator // Конкретные Декораторы расширяют базовое поведение компонента.
{
    private $doctor;

    public function __construct(IOutput $record, $doctor)
    {
        $this->doctor = $doctor;
        parent::__construct($record);
    }

    public function render()
    {
        return $this->wrapped->render()
        . "Посетил врача: {$this->doctor}" . PHP_EOL;
    }
}

class LabDecorator extends OutputParentDecorator // Конкретные Декораторы расширяют базовое поведение компонента.
{
    private $analyzes = [];

    public function __construct(IOutput $record, array $analyzes)
    {
        $this->analyzes = $analyzes;
        parent::__construct($record);
    }

    public function render()
    {
        $analyzes = implode(", ", $this->analyzes);

        return $this->wrapped->render()
        . "Результат анализов: {$analyzes}" . PHP_EOL;
    }
}

class FlurDecorator extends OutputParentDecorator // Конкретные Декораторы расширяют базовое поведение компонента.
{
    private $flur;

    public function __construct(IOutput $record, $flur)
    {
        $this->flur = $flur;
        parent::__construct($record);
    }

    public function render()
    {
        $flur = $this->flur ? "Флюрография пройдена" : "Флюрография не пройдена";

        return $this->wrapped->render()
        . "Результат флюрографии: {$flur}" . PHP_EOL;
    }
}

echo $patternTitle . PHP_EOL;

echo "-----Амбулаторная карта-----" . PHP_EOL;

$ambKarta = new AmbKarta('Иванов Иван Иванович'); // Родитель всех Декораторов

$ambKarta = new DoctorDecorator($ambKarta, 'Сидоров Сергей Петрович'); // Декоратор
$ambKarta = new LabDecorator($ambKarta, ['Глюкоза: 12', 'Креатинин: 5', 'Белок: 7']); // Декоратор
$ambKarta = new FlurDecorator($ambKarta, true); // Декоратор
$ambKarta = new DoctorDecorator($ambKarta, 'Петров Петр Петрович'); // Декоратор

echo $ambKarta->render();

echo "----------------------------" . PHP_EOL;