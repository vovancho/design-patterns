<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 18:16
 */

namespace Behavioral\ChainOfResponsibilities;

$patternTitle = 'Цепочка обязанностей';

interface ComplaintInterface
{
    public const HURTS_HEAD = 'Болит голова';
    public const HURTS_SPINE = 'Болит спина';
    public const HURTS_SHAKING = 'Трясет тело';
    public const HURTS_HEART = 'Болит сердце';
    public const HURTS_SOSUDI = 'Сужены сосуды';
    public const HURTS_EYES = 'Плохо вижу';
}

abstract class BaseDoctor
{
    protected ?BaseDoctor $successor = null;
    /** @var string[] */
    protected array $complaints = [];
    protected ?string $special = null;

    public function getSpecial(): ?string
    {
        return $this->special;
    }

    public function goNextDoctor(BaseDoctor $doctor): void
    {
        $this->successor = $doctor;
    }

    public function cure(string $complaint): void //Лечить
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

    public function canCure(string $complaint): bool //Могу вылечить?
    {
        return in_array($complaint, $this->complaints);
    }
}

class Nevrolog extends BaseDoctor
{
    protected ?string $special = 'Невролог';
    protected array $complaints = [
        ComplaintInterface::HURTS_HEAD,
        ComplaintInterface::HURTS_SPINE,
        ComplaintInterface::HURTS_SHAKING,
    ];
}

class Kardiolog extends BaseDoctor
{
    protected ?string $special = 'Кардиолог';
    protected array $complaints = [
        ComplaintInterface::HURTS_HEART,
        ComplaintInterface::HURTS_SOSUDI,
    ];
}

echo $patternTitle . PHP_EOL . PHP_EOL;

$nevrolog = new Nevrolog();
$kardiolog = new Kardiolog();

$nevrolog->goNextDoctor($kardiolog);

$nevrolog->cure('Болит голова');
echo '---' . PHP_EOL;
$nevrolog->cure('Болит сердце');
echo '---' . PHP_EOL;
$nevrolog->cure('Плохо вижу');

/**
 * php Behavioral/ChainOfResponsibilities.php
 *
 * Цепочка обязанностей
 *
 * Я врач Невролог, я вылечу, если у Вас 'Болит голова'.
 * ---
 * Я врач Невролог, я не могу Вас вылечить, если у Вас 'Болит сердце'. Я направлю Вас к врачу по специальности 'Кардиолог'.
 * Я врач Кардиолог, я вылечу, если у Вас 'Болит сердце'.
 * ---
 * Я врач Невролог, я не могу Вас вылечить, если у Вас 'Плохо вижу'. Я направлю Вас к врачу по специальности 'Кардиолог'.
 * Я врач Кардиолог, ничем не можем Вам помочь.
 */
