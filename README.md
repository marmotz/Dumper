# Dumper

A pretty variable dumper for HTML & cli.

[![Build Status](https://travis-ci.org/marmotz/Dumper.png)](https://travis-ci.org/marmotz/Dumper)




## Installation with composer

```json
{
    "require": {
        "marmotz/dumper": "dev-master"
    }
}
```

In most of the cases you don't need AtoumBundle in your production environment.

```json
{
    "require-dev": {
        "marmotz/dumper": "dev-master"
    }
}
```


## Usage

Include composer autoloader in your project and use ``dump()`` function.

```php
require_once __DIR__ . '/vendor/autoload.php';

dump($_SERVER);
```

## Configuration

You can limit the depth of the dump by using setMaxLevelOfRecursion function like this:

```php
Marmotz\Dumper\Dump::setMaxLevelOfRecursion(5);
```


## Output

Dumper self-determines output type between HTML and cli.

With following code:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$array = array(
    1, 2, fopen(__FILE__, 'r'),
    uniqid() => array(
        4,
        array(
            uniqid() => 5, 'foobar'
        ),
        7
    ),
    8 => new stdClass
);

dump($array, new DateTime);
```

### CLI

Here is an example of cli output:

```
array(5)
|               0: integer(1)
|               1: integer(2)
|               2: resource stream "Resource id #11"
| "51f624bb64671": array(3)
|                  | 0: integer(4)
|                  | 1: array(2)
|                  |    | "51f624bb646ca": integer(5)
|                  |    |               0: string(6) "foobar"
|                  | 2: integer(7)
|               8: object stdClass

object DateTime
| Constants :
|   ATOM   : string(13) "Y-m-d\TH:i:sP"
|   COOKIE : string(16) "l, d-M-y H:i:s T"
|   ISO8601: string(13) "Y-m-d\TH:i:sO"
|   RFC822 : string(16) "D, d M y H:i:s O"
|   RFC850 : string(16) "l, d-M-y H:i:s T"
|   RFC1036: string(16) "D, d M y H:i:s O"
|   RFC1123: string(16) "D, d M Y H:i:s O"
|   RFC2822: string(16) "D, d M Y H:i:s O"
|   RFC3339: string(13) "Y-m-d\TH:i:sP"
|   RSS    : string(16) "D, d M Y H:i:s O"
|   W3C    : string(13) "Y-m-d\TH:i:sP"
| Methods :
|   public        __construct($time, $object)
|   public        __wakeup()
|   public static __set_state()
|   public static createFromFormat($format, $time, $object)
|   public static getLastErrors()
|   public        format($format)
|   public        modify($modify)
|   public        add($interval)
|   public        sub($interval)
|   public        getTimezone()
|   public        setTimezone($timezone)
|   public        getOffset()
|   public        setTime($hour, $minute, $second)
|   public        setDate($year, $month, $day)
|   public        setISODate($year, $week, $day)
|   public        setTimestamp($unixtimestamp)
|   public        getTimestamp()
|   public        diff($object, $absolute)


```


### HTML

Here is an example of HTML output:

![HTML Dump](https://github.com/marmotz/Dumper/raw/master/resources/readme.dump.png "HTML Dump")