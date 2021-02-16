Lists
=====

[![Build Status](https://travis-ci.org/sokil/php-list.png?branch=master&1)](https://travis-ci.org/sokil/php-list)
[![Latest Stable Version](https://poser.pugx.org/sokil/php-list/v/stable.png)](https://packagist.org/packages/sokil/php-list)
[![Coverage Status](https://coveralls.io/repos/sokil/php-list/badge.png)](https://coveralls.io/r/sokil/php-list)
[![Total Downloads](http://img.shields.io/packagist/dt/sokil/php-list.svg?1)](https://packagist.org/packages/sokil/php-list)
[![Daily Downloads](https://poser.pugx.org/sokil/php-list/d/daily)](https://packagist.org/packages/sokil/php-list/stats)

* [Installation](#installation)
* [Priority List](#priority-list)
* [Weight List](#weight-list)

## Installation

You can install library through Composer:

```javascript
{
    "require": {
        "sokil/php-list": "dev-master"
    }
}
```

## Priority Map

Priority map allows you to specify priority of items and 
iterate through this list in order to priority.

Add elements to list with priority:

```php
<?php

$list = new \Sokil\DataType\PriorityMap();
$list->set('key1', 'value1', 10);
$list->set('key2', 'value2', 100);
```

Get elements according to priority:

```php
<?php
foreach($list as $key => $value) {
    echo $key . ' - ' . $value;
}

// this will print
//   key2 - value2
//   key1 - value1
```

Get element by key:

```php
<?php

$list = new \Sokil\DataType\PriorityMap();
$list->set('key1', 'value1', 10);
$list->get('key1');
```
    
## Weight List

Weight list allows you to specify values and relative weights, and randomly
get value according to it's weight.

Imagine that we have three database servers with ip addresses: 10.0.0.1, 10.0.0.2 and 10.0.0.3.
We want to balance connections between nodes with weights 60%, 30% and 10%. So 
most connections goes to server 10.0.0.1, than to 10.0.0.2 and than to 10.0.0.3.

```
<?php

$list = new \Sokil\DataType\WeightList([
    '10.0.0.1' => 60,
    '10.0.0.2' => 30,
    '10.0.0.3' => 10,
]);

$ipAddress = $list->getRandomValue();
```
    
Now we have address on every request relatively to it's weight.
