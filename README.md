# custom-date
Custom Date Compare Class


```bash
git clone git@github.com:ignatenkovnikita/custom-date.git
composer install

./vendor/bin/phpunit  tests/
```
Example usage

```php
$string = '01:00:05 21.07.2017';
$date = new CustomDate($string);
$date->getFormatted($format); // format datetime 
```

 TODO 
 * add support other time string
 * add test for get sortable array DESC
