<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 18:16
 */

namespace Behavioral\ChainOfResponsibilities;

$patternTitle = 'Цепочка обязанностей';

interface IComplaints
{
    const HURTS_HEAD = 'Болит голова';
    const HURTS_SPINE = 'Болит спина';
    const HURTS_SHAKING = 'Тресет тело';
    const HURTS_HEART = 'Болит сердце';
    const HURTS_SOSUDI = 'Сужены сосуды';
    const HURTS_EYES = 'Плохо вижу';
}

abstract class BaseDoctor
{
    /** @var BaseDoctor */
    protected $successor;
    protected $complaints = [];
    protected $special;

    public function getSpecial()
    {
        return $this->special;
    }

    public function goNextDoctor(BaseDoctor $doctor)
    {
        $this->successor = $doctor;
    }

    public function cure($complaint) //Лечить
    {
        if ($this->canCure($complaint)) {
            echo "Я врач {$this->special}, я вылечу, если у Вас '$complaint'." . PHP_EOL;
        } elseif ($this->successor) {
            echo "Я врач {$this->special}, я не могу Вас вылечить, если у Вас '$complaint'. Я направлю Вас к врачу по специальности '{$this->successor->getSpecial()}'." . PHP_EOL;
            $this->successor->cure($complaint);
        } else {
            echo "Я врач {$this->special}, ничем не можем Вам помочь." . PHP_EOL;
        }
    }

    public function canCure($complaint) //Могу вылечить?
    {
        return in_array($complaint, $this->complaints);
    }
}

class Nevrolog extends BaseDoctor
{
    protected $special = 'Невролог';
    protected $complaints = [
        IComplaints::HURTS_HEAD,
        IComplaints::HURTS_SPINE,
        IComplaints::HURTS_SHAKING,
    ];
}

class Kardiolog extends BaseDoctor
{
    protected $special = 'Кардиолог';
    protected $complaints = [
        IComplaints::HURTS_HEART,
        IComplaints::HURTS_SOSUDI,
    ];
}

echo $patternTitle . PHP_EOL;

$nevrolog = new Nevrolog();
$kardiolog = new Kardiolog();

$nevrolog->goNextDoctor($kardiolog);

$nevrolog->cure('Болит голова');
$nevrolog->cure('Болит сердце');
$nevrolog->cure('Плохо вижу');