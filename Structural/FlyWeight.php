<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 17:00
 */

namespace Structural\FlyWeight;

$patternTitle = 'Приспособленец/Легковес';

interface IPatient // Интерфейс Приспособленеца
{
    const AMB = 'Амбулаторная';
    const STACIONAR = 'Стационарная';

    public function getData($type); // Передача типа карты как внешнее осстояние
}

class Patient implements IPatient // Приспособленец. Внутреннее состояние получает только через конструктор
{
    private $fio;

    public function __construct($fio)
    {
        $this->fio = $fio;
    }

    public function getData($type)
    {
        return "Тип карты: $type" . PHP_EOL
            . "Пациент: {$this->fio}" . PHP_EOL;
    }
}

class Patients // Фабрика легковесов решает когда нужно создать новый легковес, а когда можно обойтись существующим.
{
    private $patients = [];

    /**
     * @param $fio
     * @return IPatient
     */
    public function get($fio)
    {
        if (empty($this->patients[$fio])) {
            $this->patients[$fio] = new Patient($fio);
        }

        return $this->patients[$fio];
    }
}

echo $patternTitle . PHP_EOL;

$patientsFactory = new Patients();

$patients = [
    'Иванов Иван Иванович',
    'Петров Петр Петрович',
    'Иванов Иван Иванович',
    'Сидоров Николай Ефимович',
];

foreach ($patients as $patientFIO) { // Пациенты кэшируются (т.к. имеют внутреннее состояние)
    foreach ([IPatient::AMB, IPatient::STACIONAR] as $typeKart) { // Здесь передается внешее состояние
        $patientFromFlyweight = $patientsFactory->get($patientFIO);
        echo $patientFromFlyweight->getData($typeKart);
    }
}

/**
 * php Structural/FlyWeight.php
 * Приспособленец/Легковес
 * Тип карты: Амбулаторная
 * Пациент: Иванов Иван Иванович
 * Тип карты: Стационарная
 * Пациент: Иванов Иван Иванович
 * Тип карты: Амбулаторная
 * Пациент: Петров Петр Петрович
 * Тип карты: Стационарная
 * Пациент: Петров Петр Петрович
 * Тип карты: Амбулаторная
 * Пациент: Иванов Иван Иванович
 * Тип карты: Стационарная
 * Пациент: Иванов Иван Иванович
 * Тип карты: Амбулаторная
 * Пациент: Сидоров Николай Ефимович
 * Тип карты: Стационарная
 * Пациент: Сидоров Николай Ефимович
 */