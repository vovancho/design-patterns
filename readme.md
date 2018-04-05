# Design-Patterns
*(Шаблоны проектирования)*

## Поведенческие *[(Behavioral)](https://github.com/vovancho/design-patterns/tree/master/Behavioral)*

### Цепочка обязанностей
*[Chain Of Responsibilities](https://github.com/vovancho/design-patterns/blob/master/Behavioral/ChainOfResponsibilities.php)*

![Chain Of Responsibilities](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_ChainOfResponsibilities.png)

```php
$nevrolog = new Nevrolog();
$kardiolog = new Kardiolog();
$nevrolog->goNextDoctor($kardiolog);
$nevrolog->cure('Болит голова');
$nevrolog->cure('Болит сердце');
$nevrolog->cure('Плохо вижу');
/**
 * php Behavioral/ChainOfResponsibilities.php
 * Цепочка обязанностей
 * Я врач Невролог, я вылечу, если у Вас 'Болит голова'.
 * Я врач Невролог, я не могу Вас вылечить, если у Вас 'Болит сердце'. Я направлю Вас к врачу по специальности 'Кардиолог'.
 * Я врач Кардиолог, я вылечу, если у Вас 'Болит сердце'.
 * Я врач Невролог, я не могу Вас вылечить, если у Вас 'Плохо вижу'. Я направлю Вас к врачу по специальности 'Кардиолог'.
 * Я врач Кардиолог, ничем не можем Вам помочь.
 */
```

### Команда
*[Command](https://github.com/vovancho/design-patterns/blob/master/Behavioral/Command.php)*

![Command](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_Command.png)

```php
$patient = new Patient('Иванов Иван Иванович');

$doctorTakeAmbKartaCommand = new GiveAmbKarta($patient);
$doctorGiveAmbKartaCommand = new TakeAmbKarta($patient);

$doctor = new Doctor();
$doctor->execute($doctorTakeAmbKartaCommand);
$doctor->execute($doctorGiveAmbKartaCommand);

/**
 * php Behavioral/Command.php
 * Команда
 * Пациент 'Иванов Иван Иванович' передает амбулаторную карту врачу.
 * Пациент 'Иванов Иван Иванович' забирает амбулаторную карту у врача.
 */
```

### Итератор
*[Iterator](https://github.com/vovancho/design-patterns/blob/master/Behavioral/Iterator.php)*

![Iterator](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_Iterator.png)

```php
$vrach1 = new Vrach('Невролог', 'Иванов Иван Иванович');
$vrach2 = new Vrach('Кардиолог', 'Петров Петр Петрович');
$vrach3 = new Vrach('Терапевт', 'Сидоров Сергей Сергеевич');

$employees = new Employees;
$employees->addEmployee($vrach1);
$employees->addEmployee($vrach2);
$employees->addEmployee($vrach3);

echo 'Количество сотрулников: ' . count($employees) . PHP_EOL;
/** @var Vrach $employee */
foreach ($employees as $employee) {
    echo $employee->getDescription();
}

$employees->removeEmployee($vrach2);
echo 'Количество сотрулников после исключения 1-го врача: ' . count($employees) . PHP_EOL;

/**
 * php Behavioral/Iterator.php
 * Итератор
 * Количество сотрулников: 3
 * Врач: Невролог, Иванов Иван Иванович
 * Врач: Кардиолог, Петров Петр Петрович
 * Врач: Терапевт, Сидоров Сергей Сергеевич
 * Количество сотрулников после исключения 1-го врача: 2
 */
```

### Посредник
*[Mediator](https://github.com/vovancho/design-patterns/blob/master/Behavioral/Mediator.php)*

![Mediator](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_Mediator.png)

```php
$patient = new Patient('Иванов Иван Иванович'); // Коллега/Компонент
$doctor = new Doctor('Ефимов Ефим Ефимович'); // Коллега/Компонент
$ambKarta = new AmbKarta(1); // Коллега/Компонент

new AmbKartaMediator($patient, $doctor, $ambKarta); // Посредник между компонентами Patient, Doctor, AmbKarta

$ambKarta->getRecord(); // метод оповещения посредника

/**
 * php Behavioral/Mediator.php
 * Посредник
 * Выписка из амбулаторной карты №1:
 * Пациент 'Иванов Иван Иванович' посетил врача 'Ефимов Ефим Ефимович'
 */
```

### Хранитель/Снимок
*[Momento](https://github.com/vovancho/design-patterns/blob/master/Behavioral/Momento.php)*

![Momento](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_Momento.png)

```php
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
```

### Наблюдатель
*[Observer](https://github.com/vovancho/design-patterns/blob/master/Behavioral/Observer.php)*

![Observer](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_Observer.png)

```php
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
```

### Состояние
*[State](https://github.com/vovancho/design-patterns/blob/master/Behavioral/State.php)*

![State](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_State.png)

```php
$patient1 = new Patient();
$patient1->setState(new PatientEnteredSick());
echo '1. Состояние пациента 1: ' . $patient1->getStatus() . PHP_EOL;
$patient1->done();
echo '2. Состояние пациента 1: ' . $patient1->getStatus() . PHP_EOL;
$patient1->done();
echo '3. Состояние пациента 1: ' . $patient1->getStatus() . PHP_EOL;

$patient2 = new Patient();
$patient2->setState(new PatientEnteredHealthy());
echo '1. Состояние пациента 2: ' . $patient2->getStatus() . PHP_EOL;
$patient2->done();
echo '2. Состояние пациента 2: ' . $patient2->getStatus() . PHP_EOL;

/**
 * php Behavioral/State.php
 * Состояние
 * 1. Состояние пациента 1: Поступил
 * 2. Состояние пациента 1: Лечится
 * 3. Состояние пациента 1: Выздоровел
 * 1. Состояние пациента 2: Поступил
 * 2. Состояние пациента 2: Здоров
 */
```

### Стратегия
*[Strategy](https://github.com/vovancho/design-patterns/blob/master/Behavioral/Strategy.php)*

![Strategy](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_Strategy.png)

```php
$outputAmbKarta = new AmbKartaStrategy();
$outputStacionar = new StacionarKartaStrategy();

$patientAmbKarta = new Patient();
$patientAmbKarta->setStrategy($outputAmbKarta);
$patientStacionar = new Patient();
$patientStacionar->setStrategy($outputStacionar);

list($fam, $im, $ot) = $patientAmbKarta->fio('Иванов', 'Иван', 'Иванович');
echo "Амбулаторная карта пациента: $fam $im $ot" . PHP_EOL;

list($fio) = $patientStacionar->fio('Петров', 'Петр', 'Петрович');
echo "Стационарная карта пациента: $fio" . PHP_EOL;

/**
 * php Behavioral/Strategy.php
 * Стратегия
 * Амбулаторная карта пациента: Иванов Иван Иванович
 * Стационарная карта пациента: Петров Петр Петрович
 */
```

### Шаблонный метод
*[TemplateMethod](https://github.com/vovancho/design-patterns/blob/master/Behavioral/TemplateMethod.php)*

![TemplateMethod](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_TemplateMethod.png)

```php
$patient = new Patient('Иванов Иван Иванович');
$patient->perform();

/**
 * php Behavioral/TemplateMethod.php
 * шаблонный метод
 * У пациента Иванов Иван Иванович умеются жалобы:
 * Болит голова
 * Болит сердце
 */
```

### Посетитель
*[Visitor](https://github.com/vovancho/design-patterns/blob/master/Behavioral/Visitor.php)*

![Visitor](https://github.com/vovancho/design-patterns/blob/master/diagrams/B_Visitor.png)

```php
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
```
