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
    public function __construct(private string $dolzh, private string $fio)
    {
    }

    public function getDescription(): string
    {
        return "Врач: $this->dolzh, $this->fio" . PHP_EOL;
    }
}

class SimpleIterator implements \Iterator
{
    private int $position = 0;

    public function __construct(private EmployeesCollection $collection)
    {
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): Vrach
    {
        return $this->collection->getEmployees()[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position = $this->position + 1;
    }

    public function valid(): bool
    {
        return isset($this->collection->getEmployees()[$this->position]);
    }
}

class EmployeesCollection implements \IteratorAggregate
{
    private array $employees = [];

    public function getEmployees(): array
    {
        return $this->employees;
    }

    public function addEmployee(Vrach $vrach): void
    {
        array_push($this->employees, $vrach);
    }

    // Фабричный метод используется, чтобы подклассы коллекций могли создавать подходящие им итераторы
    public function getIterator(): \Iterator
    {
        return new SimpleIterator($this);
    }
}

echo $patternTitle . PHP_EOL . PHP_EOL;

$employees = new EmployeesCollection;
$employees->addEmployee(new Vrach('Невролог', 'Иванов Иван Иванович'));
$employees->addEmployee(new Vrach('Кардиолог', 'Петров Петр Петрович'));
$employees->addEmployee(new Vrach('Терапевт', 'Сидоров Сергей Сергеевич'));

/** @var Vrach $employee */
foreach ($employees->getIterator() as $employee) {
    echo $employee->getDescription();
}

/**
 * php Behavioral/Iterator.php
 *
 * Итератор
 *
 * Врач: Невролог, Иванов Иван Иванович
 * Врач: Кардиолог, Петров Петр Петрович
 * Врач: Терапевт, Сидоров Сергей Сергеевич
 */
