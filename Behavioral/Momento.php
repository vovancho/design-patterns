<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 28.06.2017
 * Time: 16:40
 */

namespace Behavioral\Momento;

$patternTitle = 'Хранитель/Снимок';

class AmbKartaMomento // Конкретный снимок содержит инфраструктуру для хранения состояния Создателя
{
    private \DateTime $date;

    public function __construct(private string $content)
    {
        $this->date = new \DateTime();
    }

    public function getContent(): string // Создатель использует этот метод, когда восстанавливает своё состояние
    {
        return $this->content;
    }

    public function getDate(): \DateTime // Остальные методы используются Опекуном для отображения метаданных
    {
        return $this->date;
    }
}

class AmbKarta // Исходный класс (Создатель) содержит некоторое важное состояние, которое может со временем меняться
{
    protected string $content = '';

    public function record(string $record): void // Бизнес-логика Создателя, которая может повлиять на его внутреннее состояние
    {
        $this->content .= $record . PHP_EOL;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function save(): AmbKartaMomento // Сохраняет текущее состояние внутри снимка
    {
        return new AmbKartaMomento($this->content);
    }

    public function restore(AmbKartaMomento $memento): void // Восстанавливает состояние из объекта снимка
    {
        $this->content = $memento->getContent();
    }
}


class AmbKartaBackup
{
    private array $mementos = [];

    public function __construct(private AmbKarta $ambKarta)
    {
    }

    public function backup(): void
    {
        $this->mementos[] = $this->ambKarta->save();
    }

    public function undo(): void
    {
        if (empty($this->mementos)) {
            return;
        }

        $memento = array_pop($this->mementos);

        try {
            $this->ambKarta->restore($memento);
        } catch (\Exception $e) {
            $this->undo();
        }
    }

    public function showHistory(): string
    {
        return implode(PHP_EOL, array_map(
            fn(AmbKartaMomento $memento) => "{$memento->getDate()->format(\DateTimeInterface::ISO8601)}:\n{$memento->getContent()}",
            $this->mementos,
        ));
    }
}

echo $patternTitle . PHP_EOL . PHP_EOL;

$ambKartaBackup = new AmbKartaBackup($ambKarta = new AmbKarta());

$ambKarta->record('День 1: Пациент посетил врача невролога');
$ambKartaBackup->backup();

$ambKarta->record('День 2: Пациент посетил врача кардиолога');
$ambKartaBackup->backup();

echo '---- Текущее состояние ----' . PHP_EOL;
echo $ambKartaBackup->showHistory() . '----' . PHP_EOL . PHP_EOL;

$ambKartaBackup->undo();

echo '---- Текущее состояние после undo ----' . PHP_EOL;
echo $ambKartaBackup->showHistory() . '----' . PHP_EOL;

/**
 * Хранитель/Снимок
 *
 * ---- Текущее состояние ----
 * 2021-07-13T09:35:13+0000:
 * День 1: Пациент посетил врача невролога
 *
 * 2021-07-13T09:35:13+0000:
 * День 1: Пациент посетил врача невролога
 * День 2: Пациент посетил врача кардиолога
 * ----
 *
 * ---- Текущее состояние после undo ----
 * 2021-07-13T09:35:13+0000:
 * День 1: Пациент посетил врача невролога
 * ----
 */
