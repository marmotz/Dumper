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

In most of the cases you don't need Dumper in your production environment.

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
{{cli-dump}}
```


### HTML

Here is an example of HTML output:

![HTML Dump](https://github.com/marmotz/Dumper/raw/master/resources/readme.dump.png "HTML Dump")