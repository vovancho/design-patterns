<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 28.06.2017
 * Time: 16:40
 */

namespace Behavioral\Momento;

$patternTitle = 'Хранитель/Снимок';

class AmbKartaMomento // Хранитель
{
    protected $content = '';

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}

class AmbKarta // Исходный класс
{
    protected $content = '';

    public function record($record)
    {
        $this->content .= $record . PHP_EOL;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function save() // Операция создания снимков
    {
        return new AmbKartaMomento($this->content);
    }

    public function restore(AmbKartaMomento $memento) // Операция восстановления состояния из снимков
    {
        $this->content = $memento->getContent();
    }
}

echo $patternTitle . PHP_EOL;

$day1_AmbKarta = new AmbKarta();
$day1_AmbKarta->record('День 1: Пациент посетил врача невролога');
$registratura = $day1_AmbKarta->save();

$day2_AmbKarta = new AmbKarta();
$day2_AmbKarta->restore($registratura); // Восстанавливаем состояние карты от первого дня
$day2_AmbKarta->record('День 2: Пациент посетил врача кардиолога');

echo $day2_AmbKarta->getContent();

/**
 * php Behavioral/Momento.php
 * Хранитель/Снимок
 * День 1: Пациент посетил врача невролога
 * День 2: Пациент посетил врача кардиолога
 */