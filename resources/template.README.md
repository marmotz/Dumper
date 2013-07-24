# Dumper

A pretty variable dumper for HTML & cli.


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


## Output

Dumper self-determines output type between HTML and cli.

With following code:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

dump($_SERVER, new DateTime);
```

### CLI

Here is an example of cli output:

```
{{cli-dump}}
```


### HTML

Here is an example of HTML output:

```html
{{html-dump}}
```

{{html-dump}}