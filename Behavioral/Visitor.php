<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 27.06.2017
 * Time: 19:13
 */

namespace Behavioral\Visitor;

$patternTitle = 'Посетитель';

interface IDoctor // Место посещения
{
    public function accept(IPatient $patient);
}

interface IPatient // Посетитель
{
    public function visitNevrolog(Nevrolog $nevrolog);

    public function visitKardiolog(Kardiolog $kardiolog);
}

class Nevrolog implements IDoctor
{
    public function hurtsHead()
    {
        echo "Болит голова" . PHP_EOL;
    }

    public function accept(IPatient $patient)
    {
        $patient->visitNevrolog($this);
    }
}

class Kardiolog implements IDoctor
{
    public function hurtsHeart()
    {
        echo "Болит сердце" . PHP_EOL;
    }

    public function accept(IPatient $patient)
    {
        $patient->visitKardiolog($this);
    }
}

class PatientComplaints implements IPatient
{
    public function visitNevrolog(Nevrolog $nevrolog)
    {
        $nevrolog->hurtsHead();
    }

    public function visitKardiolog(Kardiolog $kardiolog)
    {
        $kardiolog->hurtsHeart();
    }
}

echo $patternTitle . PHP_EOL;

$nevrolog = new Nevrolog();
$kardiolog = new Kardiolog();

$patientComplaints = new PatientComplaints();

echo "Я врач невролог, пациент жалуется, что у него:" . PHP_EOL;
$nevrolog->accept($patientComplaints);
echo "Я врач кардиолог, пациент жалуется, что у него:" . PHP_EOL;
$kardiolog->accept($patientComplaints);

/**
 * php Behavioral/Visitor.php
 * Посетитель
 * Я врач невролог, пациент жалуется, что у него:
 * Болит голова
 * Я врач кардиолог, пациент жалуется, что у него:
 * Болит сердце
 */