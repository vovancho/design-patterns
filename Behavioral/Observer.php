<?php
/**
 * Created by PhpStorm.
 * User: Владимир
 * Date: 15.03.2018
 * Time: 12:01
 */

namespace Behavioral\Observer;

use SplObjectStorage;
use SplObserver;
use SplSubject;

$patternTitle = 'Наблюдатель';

class PatientObserver implements \SplObserver // Конкретные Наблюдатели реагируют на обновления, выпущенные Издателем, к которому они прикреплены
{
    public function __construct(private string $fio)
    {
    }

    public function update(SplSubject $subject)
    {
        /** @var $subject SmsObservableSubject */
        echo sprintf('Пациент "%s" получил sms сообщение с текстом "%s"', $this->fio, $subject->getSmsText()) . PHP_EOL;
    }
}

class SmsObservableSubject implements \SplSubject // Издатель владеет некоторым важным состоянием и оповещает наблюдателей о его изменениях
{
    private ?string $sms; // Для удобства в этой переменной хранится текст сообщения Издателя, необходимый всем подписчикам

    private SplObjectStorage $observers; // Список подписчиков

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void // Запуск обновления в каждом подписчике.
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function sendSms(string $sms): void // Обычно логика подписки – только часть того, что делает Издатель.
    {                                          // Издатели часто содержат некоторую важную бизнес-логику, которая запускает метод уведомления всякий раз, когда должно произойти что-то важное (или после этого)
        $this->sms = $sms;
        $this->notify();
    }

    public function getSmsText(): string
    {
        return $this->sms;
    }
}

echo $patternTitle . PHP_EOL . PHP_EOL;

$patientObserver1 = new PatientObserver('Иванов Иван Иванович');
$patientObserver2 = new PatientObserver('Петров Петр Петрович');

$smsObservableSubject = new SmsObservableSubject();
$smsObservableSubject->attach($patientObserver1);
$smsObservableSubject->attach($patientObserver2);

$smsObservableSubject->sendSms('В поликлинике день открытых дверей в эти выходные.');

echo '----------------' . PHP_EOL;

$smsObservableSubject->sendSms('Не забудьте пройти диспансеризацию в этом году.');

/**
 * php Behavioral/Observer.php
 *
 * Наблюдатель
 *
 * Пациент "Иванов Иван Иванович" получил sms сообщение с текстом "В поликлинике день открытых дверей в эти выходные."
 * Пациент "Петров Петр Петрович" получил sms сообщение с текстом "В поликлинике день открытых дверей в эти выходные."
 * ----------------
 * Пациент "Иванов Иван Иванович" получил sms сообщение с текстом "Не забудьте пройти диспансеризацию в этом году."
 * Пациент "Петров Петр Петрович" получил sms сообщение с текстом "Не забудьте пройти диспансеризацию в этом году."
 */
