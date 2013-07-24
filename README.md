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
| "51efe4a1ec51d": array(3)
|                  | 0: integer(4)
|                  | 1: array(2)
|                  |    | "51efe4a1ec566": integer(5)
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

```html
<div class="dumper">
    <table class="array">
        <thead>
            <tr>
                <th colspan="2">array(5)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    <span class="integer">0</span>
                </th>
                <td>
                    <span class="integer">integer(1)</span>
                </td>
            </tr>
            <tr>
                <th>
                    <span class="integer">1</span>
                </th>
                <td>
                    <span class="integer">integer(2)</span>
                </td>
            </tr>
            <tr>
                <th>
                    <span class="integer">2</span>
                </th>
                <td>
                    <span class="resource">resource stream "Resource id #11"</span>
                </td>
            </tr>
            <tr>
                <th>
                    <span class="string">"51efe4a1ec51d"</span>
                </th>
                <td>
                    <table class="array">
                        <thead>
                            <tr>
                                <th colspan="2">array(3)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    <span class="integer">0</span>
                                </th>
                                <td>
                                    <span class="integer">integer(4)</span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="integer">1</span>
                                </th>
                                <td>
                                    <table class="array">
                                        <thead>
                                            <tr>
                                                <th colspan="2">array(2)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <span class="string">"51efe4a1ec566"</span>
                                                </th>
                                                <td>
                                                    <span class="integer">integer(5)</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <span class="integer">0</span>
                                                </th>
                                                <td>
                                                    <span class="string">string(6) "foobar"</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="integer">2</span>
                                </th>
                                <td>
                                    <span class="integer">integer(7)</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th>
                    <span class="integer">8</span>
                </th>
                <td>
                    <table class="object">
                        <thead>
                            <tr>
                                <th>object stdClass</th>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<style type="text/css">
    .dumper, .dumper table {
        background-color: white;
        color: black;
        font-family: sans-serif;
        font-size: 12px;
    }
    .dumper table {
        border-spacing: 1px;
        background-color: white;
    }
    .dumper table tbody th {
        text-align: left;
    }
    .dumper table tbody td {
        background: #EEE;
    }
    .dumper > table.array, .dumper > table.object {
        margin: 10px 0;
        box-shadow: 2px 2px 10px black;
    }
    .dumper table.array, .dumper table.object {
        border: 1px solid black;
    }
    .dumper table.array {
        border-color: #345678;
    }
    .dumper table.array thead {
        background-color: #345678;
        color: white;
    }
    .dumper table.array tbody > tr > th {
        background-color: #56789A;
        color: white;
    }
    .dumper table.object {
        border-color: #347856;
    }
    .dumper table.object thead {
        background-color: #347856;
        color: white;
    }
    .dumper table.object tbody > tr > th {
        background-color: #569A78;
        color: white;
    }
</style>

<div class="dumper">
    <table class="object">
        <thead>
            <tr>
                <th>object DateTime</th>
            </tr>
        </thead>
        <tbody class="constants">
            <tr>
                <th>Constants :</th>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td class="name">ATOM</td>
                            <td class="value">
                                <span class="string">string(13) "Y-m-d\TH:i:sP"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">COOKIE</td>
                            <td class="value">
                                <span class="string">string(16) "l, d-M-y H:i:s T"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">ISO8601</td>
                            <td class="value">
                                <span class="string">string(13) "Y-m-d\TH:i:sO"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC822</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC850</td>
                            <td class="value">
                                <span class="string">string(16) "l, d-M-y H:i:s T"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC1036</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC1123</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M Y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC2822</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M Y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC3339</td>
                            <td class="value">
                                <span class="string">string(13) "Y-m-d\TH:i:sP"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RSS</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M Y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">W3C</td>
                            <td class="value">
                                <span class="string">string(13) "Y-m-d\TH:i:sP"</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
        <tbody class="methods">
            <tr>
                <th>Methods :</th>
            </tr>
            <tr>
                <td>public __construct($time, $object)</td>
            </tr>
            <tr>
                <td>public __wakeup()</td>
            </tr>
            <tr>
                <td>static public __set_state()</td>
            </tr>
            <tr>
                <td>static public createFromFormat($format, $time, $object)</td>
            </tr>
            <tr>
                <td>static public getLastErrors()</td>
            </tr>
            <tr>
                <td>public format($format)</td>
            </tr>
            <tr>
                <td>public modify($modify)</td>
            </tr>
            <tr>
                <td>public add($interval)</td>
            </tr>
            <tr>
                <td>public sub($interval)</td>
            </tr>
            <tr>
                <td>public getTimezone()</td>
            </tr>
            <tr>
                <td>public setTimezone($timezone)</td>
            </tr>
            <tr>
                <td>public getOffset()</td>
            </tr>
            <tr>
                <td>public setTime($hour, $minute, $second)</td>
            </tr>
            <tr>
                <td>public setDate($year, $month, $day)</td>
            </tr>
            <tr>
                <td>public setISODate($year, $week, $day)</td>
            </tr>
            <tr>
                <td>public setTimestamp($unixtimestamp)</td>
            </tr>
            <tr>
                <td>public getTimestamp()</td>
            </tr>
            <tr>
                <td>public diff($object, $absolute)</td>
            </tr>
        </tbody>
    </table>
</div>


```

<div class="dumper">
    <table class="array">
        <thead>
            <tr>
                <th colspan="2">array(5)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    <span class="integer">0</span>
                </th>
                <td>
                    <span class="integer">integer(1)</span>
                </td>
            </tr>
            <tr>
                <th>
                    <span class="integer">1</span>
                </th>
                <td>
                    <span class="integer">integer(2)</span>
                </td>
            </tr>
            <tr>
                <th>
                    <span class="integer">2</span>
                </th>
                <td>
                    <span class="resource">resource stream "Resource id #11"</span>
                </td>
            </tr>
            <tr>
                <th>
                    <span class="string">"51efe4a1ec51d"</span>
                </th>
                <td>
                    <table class="array">
                        <thead>
                            <tr>
                                <th colspan="2">array(3)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    <span class="integer">0</span>
                                </th>
                                <td>
                                    <span class="integer">integer(4)</span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="integer">1</span>
                                </th>
                                <td>
                                    <table class="array">
                                        <thead>
                                            <tr>
                                                <th colspan="2">array(2)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <span class="string">"51efe4a1ec566"</span>
                                                </th>
                                                <td>
                                                    <span class="integer">integer(5)</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <span class="integer">0</span>
                                                </th>
                                                <td>
                                                    <span class="string">string(6) "foobar"</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="integer">2</span>
                                </th>
                                <td>
                                    <span class="integer">integer(7)</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th>
                    <span class="integer">8</span>
                </th>
                <td>
                    <table class="object">
                        <thead>
                            <tr>
                                <th>object stdClass</th>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="dumper">
    <table class="object">
        <thead>
            <tr>
                <th>object DateTime</th>
            </tr>
        </thead>
        <tbody class="constants">
            <tr>
                <th>Constants :</th>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td class="name">ATOM</td>
                            <td class="value">
                                <span class="string">string(13) "Y-m-d\TH:i:sP"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">COOKIE</td>
                            <td class="value">
                                <span class="string">string(16) "l, d-M-y H:i:s T"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">ISO8601</td>
                            <td class="value">
                                <span class="string">string(13) "Y-m-d\TH:i:sO"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC822</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC850</td>
                            <td class="value">
                                <span class="string">string(16) "l, d-M-y H:i:s T"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC1036</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC1123</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M Y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC2822</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M Y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RFC3339</td>
                            <td class="value">
                                <span class="string">string(13) "Y-m-d\TH:i:sP"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">RSS</td>
                            <td class="value">
                                <span class="string">string(16) "D, d M Y H:i:s O"</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">W3C</td>
                            <td class="value">
                                <span class="string">string(13) "Y-m-d\TH:i:sP"</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
        <tbody class="methods">
            <tr>
                <th>Methods :</th>
            </tr>
            <tr>
                <td>public __construct($time, $object)</td>
            </tr>
            <tr>
                <td>public __wakeup()</td>
            </tr>
            <tr>
                <td>static public __set_state()</td>
            </tr>
            <tr>
                <td>static public createFromFormat($format, $time, $object)</td>
            </tr>
            <tr>
                <td>static public getLastErrors()</td>
            </tr>
            <tr>
                <td>public format($format)</td>
            </tr>
            <tr>
                <td>public modify($modify)</td>
            </tr>
            <tr>
                <td>public add($interval)</td>
            </tr>
            <tr>
                <td>public sub($interval)</td>
            </tr>
            <tr>
                <td>public getTimezone()</td>
            </tr>
            <tr>
                <td>public setTimezone($timezone)</td>
            </tr>
            <tr>
                <td>public getOffset()</td>
            </tr>
            <tr>
                <td>public setTime($hour, $minute, $second)</td>
            </tr>
            <tr>
                <td>public setDate($year, $month, $day)</td>
            </tr>
            <tr>
                <td>public setISODate($year, $week, $day)</td>
            </tr>
            <tr>
                <td>public setTimestamp($unixtimestamp)</td>
            </tr>
            <tr>
                <td>public getTimestamp()</td>
            </tr>
            <tr>
                <td>public diff($object, $absolute)</td>
            </tr>
        </tbody>
    </table>
</div>

