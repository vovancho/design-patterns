<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 28.06.2017
 * Time: 15:09
 */
namespace Structural\Proxy;

$patternTitle = 'Заместитель';

interface IObsledovanie
{
    public function setPatient($doctorFIO, $patientFIO);
}

class Obsledovanie implements IObsledovanie // Оригинальный служебный объект
{
    public function setPatient($doctorFIO, $patientFIO)
    {
        echo "Пациент '$patientFIO' пришел на прием к врачу '$doctorFIO'" . PHP_EOL;
    }
}

class ObsledovaniePriemProxy implements IObsledovanie // Заместитель оригинального класса
{
    private $patients = [];
    private $obsledovanie;

    public function __construct()
    {
        $this->obsledovanie = new Obsledovanie(); // Создаем оригинальный класс, можно передать ссылку через конструктор
    }

    public function setPatient($doctorFIO, $patientFIO)
    {
        $this->obsledovanie->setPatient($doctorFIO, $patientFIO); // Переадресовываем запрос оригинальному классу

        if (empty($this->patients[$patientFIO])) { // Добавляем свою функциональность
            $this->patients[$patientFIO] = $doctorFIO;
            echo " Тип приема: Первичный." . PHP_EOL;
        } else {
            echo " Тип приема: Вторичный." . PHP_EOL;
        }
    }
}

echo $patternTitle . PHP_EOL;

$obsledovaniePriemProxy = new ObsledovaniePriemProxy();

$obsledovaniePriemProxy->setPatient('Сидоров Иван Иванович', 'Петров Петр Петрович'); // Первичный
$obsledovaniePriemProxy->setPatient('Сидоров Иван Иванович', 'Петров Петр Петрович'); // Вторичный
$obsledovaniePriemProxy->setPatient('Сидоров Сергей Ефимович', 'Иванов Иван Иванович'); // Первичный