Priority List
=============

You can install library through Composer:

```javascript
{
    "require": {
        "sokil/php-prioritylist": "dev-master"
    }
}
```

Add elements to list with priority definition:

```php
<?php

$list = new PriorityList();
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

<?php

$list = new PriorityList();
$list->set('key1', 'value1', 10);
$list->get('key2');
```