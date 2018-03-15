<?php
/**
 * Created by PhpStorm.
 * User: Владимир
 * Date: 15.03.2018
 * Time: 10:25
 */

namespace Behavioral\Iterator;

$patternTitle = 'Итератор';

class Vrach
{

    private $dolzh;
    private $fio;

    public function __construct($dolzh, $fio)
    {
        $this->dolzh = $dolzh;
        $this->fio = $fio;
    }

    public function getDescription()
    {
        return 'Врач: ' . $this->dolzh . ', ' . $this->fio . PHP_EOL;
    }
}

class Employees implements \Countable, \Iterator
{
    private $employees = [];
    private $currentIndex = 0;

    public function current()
    {
        return $this->employees[$this->currentIndex];
    }

    public function next()
    {
        $this->currentIndex++;
    }

    public function key()
    {
        return $this->currentIndex;
    }

    public function valid()
    {
        return isset($this->employees[$this->currentIndex]);
    }

    public function rewind()
    {
        $this->currentIndex = 0;
    }

    public function count()
    {
        return count($this->employees);
    }

    public function addEmployee(Vrach $vrach)
    {
        array_push($this->employees, $vrach);
    }

    public function removeEmployee(Vrach $vrach)
    {
        $this->employees = array_values(array_filter($this->employees, function (Vrach $vrachEmployee) use ($vrach) {
            return $vrachEmployee->getDescription() !== $vrach->getDescription();
        }));
    }
}

echo $patternTitle . PHP_EOL;

$vrach1 = new Vrach('Невролог', 'Иванов Иван Иванович');
$vrach2 = new Vrach('Кардиолог', 'Петров Петр Петрович');
$vrach3 = new Vrach('Терапевт', 'Сидоров Сергей Сергеевич');

$employees = new Employees;
$employees->addEmployee($vrach1);
$employees->addEmployee($vrach2);
$employees->addEmployee($vrach3);

echo 'Количество сотрулников: ' . count($employees) . PHP_EOL;
/** @var Vrach $employee */
foreach ($employees as $employee) {
    echo $employee->getDescription();
}

$employees->removeEmployee($vrach2);
echo 'Количество сотрулников после исключения 1-го врача: ' . count($employees) . PHP_EOL;

/**
 * php Behavioral/Iterator.php
 * Итератор
 * Количество сотрулников: 3
 * Врач: Невролог, Иванов Иван Иванович
 * Врач: Кардиолог, Петров Петр Петрович
 * Врач: Терапевт, Сидоров Сергей Сергеевич
 * Количество сотрулников после исключения 1-го врача: 2
 */