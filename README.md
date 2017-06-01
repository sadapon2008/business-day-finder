# business-day-finder

## Example

```php
<?php

require_once('vendor/autoload.php');

use HolidayJp\HolidayJp; // k1low/holiday_jp
use BusinessDayFinder\Holiday;
use BusinessDayFinder\Finder;

$holidays = HolidayJp::between(new DateTime('2010-01-01'), new DateTime('2020-12-31'));
$holidaysForFinder = array();
foreach ($holidays as $holiday) {
    $holidaysForFinder[] = new Holiday($holiday['date'], $holiday['name']);
}

$finder = new Finder();
$finder->addHolidayArray($holidaysForFinder);
$ret = $finder->getBusinessDayForward(new DateTime('2017-01-01'));

echo $ret->format('Y-m-d');
```
