<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 10:37
 */

namespace Behavioral\Strategy;

$patternTitle = 'Стратегия';

interface OutputStrategyInterface // Интерфейс Стратегии объявляет операции, общие для всех поддерживаемых версий некоторого алгоритма
{                                 // Контекст использует этот интерфейс для вызова алгоритма, определённого Конкретными Стратегиями
    public function output(string $fam, string $im, string $ot): array;
}

class AmbKartaStrategy implements OutputStrategyInterface // Конкретные Стратегии реализуют алгоритм, следуя базовому интерфейсу Стратегии
{                                                         // Этот интерфейс делает их взаимозаменяемыми в Контексте
    public function output(string $fam, string $im, string $ot): array
    {
        return [$fam, $im, $ot];
    }
}

class StacionarKartaStrategy implements OutputStrategyInterface // Конкретные Стратегии реализуют алгоритм, следуя базовому интерфейсу Стратегии
{                                                               // Этот интерфейс делает их взаимозаменяемыми в Контексте
    public function output(string $fam, string $im, string $ot): array
    {
        return [$fam . ' ' . $im . ' ' . $ot];
    }
}

class Patient // Контекст определяет интерфейс
{
    // Контекст хранит ссылку на один из объектов Стратегии
    // Контекст не знает конкретного класса стратегии. Он должен работать со всеми стратегиями через интерфейс Стратегии

    public function __construct(private ?OutputStrategyInterface $strategy = null) // Обычно Контекст принимает стратегию через конструктор, а также предоставляет сеттер для её изменения во время выполнения
    {
    }

    public function setStrategy(OutputStrategyInterface $outputStrategy) // Обычно Контекст позволяет заменить объект Стратегии во время выполнения
    {
        $this->strategy = $outputStrategy;
    }

    public function fio(string $fam, string $im, string $ot): array // Вместо того, чтобы самостоятельно реализовывать множественные версии алгоритма, Контекст делегирует некоторую работу объекту Стратегии.
    {
        return $this->strategy->output($fam, $im, $ot);
    }
}

echo $patternTitle . PHP_EOL . PHP_EOL;

$outputAmbKarta = new AmbKartaStrategy();
$outputStacionar = new StacionarKartaStrategy();

$patient = new Patient($outputAmbKarta);

[$fam, $im, $ot] = $patient->fio('Иванов', 'Иван', 'Иванович');
echo "Амбулаторная карта пациента: $fam $im $ot" . PHP_EOL;

$patient->setStrategy($outputStacionar);
[$fio] = $patient->fio('Петров', 'Петр', 'Петрович');
echo "Стационарная карта пациента: $fio" . PHP_EOL;

/**
 * php Behavioral/Strategy.php
 *
 * Стратегия
 *
 * Амбулаторная карта пациента: Иванов Иван Иванович
 * Стационарная карта пациента: Петров Петр Петрович
 */
