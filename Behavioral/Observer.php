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

class Sms
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }
}

class PatientObserver implements \SplObserver
{
    private $fio;

    public function __construct($fio)
    {
        $this->fio = $fio;
    }

    public function update(SplSubject $subject)
    {
        /** @var $subject SmsObservableSubject */
        echo sprintf('Пациент "%s" получил sms сообщение с текстом "%s"', $this->fio, $subject->getSmsText()) . PHP_EOL;
    }
}

class SmsObservableSubject implements \SplSubject
{
    private $observers;
    private $sms;

    public function __construct(Sms $sms)
    {
        $this->observers = new SplObjectStorage();
        $this->sms = $sms;
    }

    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function changeSms(Sms $sms)
    {
        $this->sms = $sms;
    }

    public function getSmsText()
    {
        return $this->sms->getText();
    }
}

echo $patternTitle . PHP_EOL;

$patientObserver1 = new PatientObserver('Иванов Иван Иванович');
$patientObserver2 = new PatientObserver('Петров Петр Петрович');

$smsObservableSubject = new SmsObservableSubject(new Sms('В поликлинике день открытых дверей в эти выходные.'));
$smsObservableSubject->attach($patientObserver1);
$smsObservableSubject->attach($patientObserver2);

$smsObservableSubject->notify();

echo '----------------' . PHP_EOL;

$smsObservableSubject->changeSms(new Sms('Не забудьте пройти диспансеризацию в этом году.'));
$smsObservableSubject->notify();

/**
 * php Behavioral/Observer.php
 * Наблюдатель
 * Пациент "Иванов Иван Иванович" получил sms сообщение с текстом "В поликлинике день открытых дверей в эти выходные."
 * Пациент "Петров Петр Петрович" получил sms сообщение с текстом "В поликлинике день открытых дверей в эти выходные."
 * ----------------
 * Пациент "Иванов Иван Иванович" получил sms сообщение с текстом "Не забудьте пройти диспансеризацию в этом году."
 * Пациент "Петров Петр Петрович" получил sms сообщение с текстом "Не забудьте пройти диспансеризацию в этом году."
 */