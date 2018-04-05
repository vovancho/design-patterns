# Design-Patterns
*(Шаблоны проектирования)*

## Поведенческие
*[Behavioral](https://github.com/vovancho/design-patterns/tree/master/Behavioral)*

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