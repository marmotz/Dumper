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


### CLI

Here is an example of cli output:

```php
<?php
    require_once __DIR__ . '/vendor/autoload.php';

    dump($_SERVER, new DateTime);
```

```
array(31)
|               "TERM_PROGRAM": string(14) "Apple_Terminal"
|                       "TERM": string(14) "xterm-256color"
|                      "SHELL": string(9) "/bin/bash"
|                     "TMPDIR": string(49) "/var/folders/k7/tfqn61hx3kzgf6g5s4rwpzbm0000gn/T/"
| "Apple_PubSub_Socket_Render": string(25) "/tmp/launch-VC6nnI/Render"
|       "TERM_PROGRAM_VERSION": string(5) "303.2"
|            "TERM_SESSION_ID": string(36) "55157284-23D5-4A9F-A370-8D0BB605246B"
|                       "USER": string(9) "rlittolff"
|               "COMMAND_MODE": string(8) "unix2003"
|              "SSH_AUTH_SOCK": string(28) "/tmp/launch-uSHJkW/Listeners"
|    "__CF_USER_TEXT_ENCODING": string(11) "0x1F5:0:91
|                               "
|     "Apple_Ubiquity_Message": string(41) "/tmp/launch-r7yHvs/Apple_Ubiquity_Message"
|                       "PATH": string(72) "/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/bin:/usr/X11/bin"
|                        "PWD": string(32) "/Users/rlittolff/dev/Dumper-test"
|                       "LANG": string(11) "fr_FR.UTF-8"
|                      "SHLVL": string(1) "1"
|                       "HOME": string(16) "/Users/rlittolff"
|              "AUTOJUMP_HOME": string(16) "/Users/rlittolff"
|                    "LOGNAME": string(9) "rlittolff"
|                    "DISPLAY": string(26) "/tmp/launch-j69yww/org.x:0"
|                          "_": string(18) "/usr/local/bin/php"
|                     "OLDPWD": string(27) "/Users/rlittolff/dev/Dumper"
|                   "PHP_SELF": string(9) "index.php"
|                "SCRIPT_NAME": string(9) "index.php"
|            "SCRIPT_FILENAME": string(9) "index.php"
|            "PATH_TRANSLATED": string(9) "index.php"
|              "DOCUMENT_ROOT": string(0) ""
|         "REQUEST_TIME_FLOAT": float(1373753202.3845)
|               "REQUEST_TIME": integer(1373753202)
|                       "argv": array(1)
|                               | 0: string(9) "index.php"
|                       "argc": integer(1)

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

```php
<?php
    require_once __DIR__ . '/vendor/autoload.php';

    dump($_SERVER);
```

```html
<table class="dumper array">
    <thead>
        <tr>
            <th colspan="2">array(27)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>"HTTP_HOST"</th>
            <td>string(23) "host-002.bouyguesbox.fr"</td>
        </tr>
        <tr>
            <th>"HTTP_CONNECTION"</th>
            <td>string(10) "keep-alive"</td>
        </tr>
        <tr>
            <th>"HTTP_CACHE_CONTROL"</th>
            <td>string(9) "max-age=0"</td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT"</th>
            <td>string(63) "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"</td>
        </tr>
        <tr>
            <th>"HTTP_USER_AGENT"</th>
            <td>string(119) "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36"</td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT_ENCODING"</th>
            <td>string(17) "gzip,deflate,sdch"</td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT_LANGUAGE"</th>
            <td>string(35) "fr-FR,fr;q=0.8,en-US;q=0.6,en;q=0.4"</td>
        </tr>
        <tr>
            <th>"PATH"</th>
            <td>string(29) "/usr/bin:/bin:/usr/sbin:/sbin"</td>
        </tr>
        <tr>
            <th>"SERVER_SIGNATURE"</th>
            <td>
                string(99) "<address>Apache/2.2.22 (Unix) DAV/2 PHP/5.4.16 Server at host-002.bouyguesbox.fr Port 80</address>
                "
            </td>
        </tr>
        <tr>
            <th>"SERVER_SOFTWARE"</th>
            <td>string(37) "Apache/2.2.22 (Unix) DAV/2 PHP/5.4.16"</td>
        </tr>
        <tr>
            <th>"SERVER_NAME"</th>
            <td>string(23) "host-002.bouyguesbox.fr"</td>
        </tr>
        <tr>
            <th>"SERVER_ADDR"</th>
            <td>string(12) "192.168.1.97"</td>
        </tr>
        <tr>
            <th>"SERVER_PORT"</th>
            <td>string(2) "80"</td>
        </tr>
        <tr>
            <th>"REMOTE_ADDR"</th>
            <td>string(12) "192.168.1.97"</td>
        </tr>
        <tr>
            <th>"DOCUMENT_ROOT"</th>
            <td>string(28) "/Library/WebServer/Documents"</td>
        </tr>
        <tr>
            <th>"SERVER_ADMIN"</th>
            <td>string(15) "you@example.com"</td>
        </tr>
        <tr>
            <th>"SCRIPT_FILENAME"</th>
            <td>string(44) "/Users/rlittolff/Sites/Dumper-test/index.php"</td>
        </tr>
        <tr>
            <th>"REMOTE_PORT"</th>
            <td>string(5) "52314"</td>
        </tr>
        <tr>
            <th>"GATEWAY_INTERFACE"</th>
            <td>string(7) "CGI/1.1"</td>
        </tr>
        <tr>
            <th>"SERVER_PROTOCOL"</th>
            <td>string(8) "HTTP/1.1"</td>
        </tr>
        <tr>
            <th>"REQUEST_METHOD"</th>
            <td>string(3) "GET"</td>
        </tr>
        <tr>
            <th>"QUERY_STRING"</th>
            <td>string(0) ""</td>
        </tr>
        <tr>
            <th>"REQUEST_URI"</th>
            <td>string(24) "/~rlittolff/Dumper-test/"</td>
        </tr>
        <tr>
            <th>"SCRIPT_NAME"</th>
            <td>string(33) "/~rlittolff/Dumper-test/index.php"</td>
        </tr>
        <tr>
            <th>"PHP_SELF"</th>
            <td>string(33) "/~rlittolff/Dumper-test/index.php"</td>
        </tr>
        <tr>
            <th>"REQUEST_TIME_FLOAT"</th>
            <td>float(1373785455.187)</td>
        </tr>
        <tr>
            <th>"REQUEST_TIME"</th>
            <td>integer(1373785455)</td>
        </tr>
    </tbody>
</table>

<table class="dumper object">
    <thead>
        <tr>
            <th colspan="3">object DateTime</th><th>
        </th></tr>
    </thead>
    <tbody class="constants">
        <tr>
            <th colspan="3">Constants :</th>
        </tr>
        <tr>
            <td class="name">ATOM</td>
            <td class="value">string(13) "Y-m-d\TH:i:sP"</td>
        </tr>
        <tr>
            <td class="name">COOKIE</td>
            <td class="value">string(16) "l, d-M-y H:i:s T"</td>
        </tr>
        <tr>
            <td class="name">ISO8601</td>
            <td class="value">string(13) "Y-m-d\TH:i:sO"</td>
        </tr>
        <tr>
            <td class="name">RFC822</td>
            <td class="value">string(16) "D, d M y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">RFC850</td>
            <td class="value">string(16) "l, d-M-y H:i:s T"</td>
        </tr>
        <tr>
            <td class="name">RFC1036</td>
            <td class="value">string(16) "D, d M y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">RFC1123</td>
            <td class="value">string(16) "D, d M Y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">RFC2822</td>
            <td class="value">string(16) "D, d M Y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">RFC3339</td>
            <td class="value">string(13) "Y-m-d\TH:i:sP"</td>
        </tr>
        <tr>
            <td class="name">RSS</td>
            <td class="value">string(16) "D, d M Y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">W3C</td>
            <td class="value">string(13) "Y-m-d\TH:i:sP"</td>
        </tr>
    </tbody>
    <tbody class="methods">
        <tr>
            <th colspan="3">Methods :</th>
        </tr>
        <tr>
            <td colspan="3">public __construct($time, $object)</td>
        </tr>
        <tr>
            <td colspan="3">public __wakeup()</td>
        </tr>
        <tr>
            <td colspan="3">static public __set_state()</td>
        </tr>
        <tr>
            <td colspan="3">static public createFromFormat($format, $time, $object)</td>
        </tr>
        <tr>
            <td colspan="3">static public getLastErrors()</td>
        </tr>
        <tr>
            <td colspan="3">public format($format)</td>
        </tr>
        <tr>
            <td colspan="3">public modify($modify)</td>
        </tr>
        <tr>
            <td colspan="3">public add($interval)</td>
        </tr>
        <tr>
            <td colspan="3">public sub($interval)</td>
        </tr>
        <tr>
            <td colspan="3">public getTimezone()</td>
        </tr>
        <tr>
            <td colspan="3">public setTimezone($timezone)</td>
        </tr>
        <tr>
            <td colspan="3">public getOffset()</td>
        </tr>
        <tr>
            <td colspan="3">public setTime($hour, $minute, $second)</td>
        </tr>
        <tr>
            <td colspan="3">public setDate($year, $month, $day)</td>
        </tr>
        <tr>
            <td colspan="3">public setISODate($year, $week, $day)</td>
        </tr>
        <tr>
            <td colspan="3">public setTimestamp($unixtimestamp)</td>
        </tr>
        <tr>
            <td colspan="3">public getTimestamp()</td>
        </tr>
        <tr>
            <td colspan="3">public diff($object, $absolute)</td>
        </tr>
    </tbody>
</table>
```

<table class="dumper array">
    <thead>
        <tr>
            <th colspan="2">array(27)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>"HTTP_HOST"</th>
            <td>string(23) "host-002.bouyguesbox.fr"</td>
        </tr>
        <tr>
            <th>"HTTP_CONNECTION"</th>
            <td>string(10) "keep-alive"</td>
        </tr>
        <tr>
            <th>"HTTP_CACHE_CONTROL"</th>
            <td>string(9) "max-age=0"</td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT"</th>
            <td>string(63) "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"</td>
        </tr>
        <tr>
            <th>"HTTP_USER_AGENT"</th>
            <td>string(119) "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36"</td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT_ENCODING"</th>
            <td>string(17) "gzip,deflate,sdch"</td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT_LANGUAGE"</th>
            <td>string(35) "fr-FR,fr;q=0.8,en-US;q=0.6,en;q=0.4"</td>
        </tr>
        <tr>
            <th>"PATH"</th>
            <td>string(29) "/usr/bin:/bin:/usr/sbin:/sbin"</td>
        </tr>
        <tr>
            <th>"SERVER_SIGNATURE"</th>
            <td>
                string(99) "<address>Apache/2.2.22 (Unix) DAV/2 PHP/5.4.16 Server at host-002.bouyguesbox.fr Port 80</address>
                "
            </td>
        </tr>
        <tr>
            <th>"SERVER_SOFTWARE"</th>
            <td>string(37) "Apache/2.2.22 (Unix) DAV/2 PHP/5.4.16"</td>
        </tr>
        <tr>
            <th>"SERVER_NAME"</th>
            <td>string(23) "host-002.bouyguesbox.fr"</td>
        </tr>
        <tr>
            <th>"SERVER_ADDR"</th>
            <td>string(12) "192.168.1.97"</td>
        </tr>
        <tr>
            <th>"SERVER_PORT"</th>
            <td>string(2) "80"</td>
        </tr>
        <tr>
            <th>"REMOTE_ADDR"</th>
            <td>string(12) "192.168.1.97"</td>
        </tr>
        <tr>
            <th>"DOCUMENT_ROOT"</th>
            <td>string(28) "/Library/WebServer/Documents"</td>
        </tr>
        <tr>
            <th>"SERVER_ADMIN"</th>
            <td>string(15) "you@example.com"</td>
        </tr>
        <tr>
            <th>"SCRIPT_FILENAME"</th>
            <td>string(44) "/Users/rlittolff/Sites/Dumper-test/index.php"</td>
        </tr>
        <tr>
            <th>"REMOTE_PORT"</th>
            <td>string(5) "52314"</td>
        </tr>
        <tr>
            <th>"GATEWAY_INTERFACE"</th>
            <td>string(7) "CGI/1.1"</td>
        </tr>
        <tr>
            <th>"SERVER_PROTOCOL"</th>
            <td>string(8) "HTTP/1.1"</td>
        </tr>
        <tr>
            <th>"REQUEST_METHOD"</th>
            <td>string(3) "GET"</td>
        </tr>
        <tr>
            <th>"QUERY_STRING"</th>
            <td>string(0) ""</td>
        </tr>
        <tr>
            <th>"REQUEST_URI"</th>
            <td>string(24) "/~rlittolff/Dumper-test/"</td>
        </tr>
        <tr>
            <th>"SCRIPT_NAME"</th>
            <td>string(33) "/~rlittolff/Dumper-test/index.php"</td>
        </tr>
        <tr>
            <th>"PHP_SELF"</th>
            <td>string(33) "/~rlittolff/Dumper-test/index.php"</td>
        </tr>
        <tr>
            <th>"REQUEST_TIME_FLOAT"</th>
            <td>float(1373785455.187)</td>
        </tr>
        <tr>
            <th>"REQUEST_TIME"</th>
            <td>integer(1373785455)</td>
        </tr>
    </tbody>
</table>

<table class="dumper object">
    <thead>
        <tr>
            <th colspan="3">object DateTime</th><th>
        </th></tr>
    </thead>
    <tbody class="constants">
        <tr>
            <th colspan="3">Constants :</th>
        </tr>
        <tr>
            <td class="name">ATOM</td>
            <td class="value">string(13) "Y-m-d\TH:i:sP"</td>
        </tr>
        <tr>
            <td class="name">COOKIE</td>
            <td class="value">string(16) "l, d-M-y H:i:s T"</td>
        </tr>
        <tr>
            <td class="name">ISO8601</td>
            <td class="value">string(13) "Y-m-d\TH:i:sO"</td>
        </tr>
        <tr>
            <td class="name">RFC822</td>
            <td class="value">string(16) "D, d M y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">RFC850</td>
            <td class="value">string(16) "l, d-M-y H:i:s T"</td>
        </tr>
        <tr>
            <td class="name">RFC1036</td>
            <td class="value">string(16) "D, d M y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">RFC1123</td>
            <td class="value">string(16) "D, d M Y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">RFC2822</td>
            <td class="value">string(16) "D, d M Y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">RFC3339</td>
            <td class="value">string(13) "Y-m-d\TH:i:sP"</td>
        </tr>
        <tr>
            <td class="name">RSS</td>
            <td class="value">string(16) "D, d M Y H:i:s O"</td>
        </tr>
        <tr>
            <td class="name">W3C</td>
            <td class="value">string(13) "Y-m-d\TH:i:sP"</td>
        </tr>
    </tbody>
    <tbody class="methods">
        <tr>
            <th colspan="3">Methods :</th>
        </tr>
        <tr>
            <td colspan="3">public __construct($time, $object)</td>
        </tr>
        <tr>
            <td colspan="3">public __wakeup()</td>
        </tr>
        <tr>
            <td colspan="3">static public __set_state()</td>
        </tr>
        <tr>
            <td colspan="3">static public createFromFormat($format, $time, $object)</td>
        </tr>
        <tr>
            <td colspan="3">static public getLastErrors()</td>
        </tr>
        <tr>
            <td colspan="3">public format($format)</td>
        </tr>
        <tr>
            <td colspan="3">public modify($modify)</td>
        </tr>
        <tr>
            <td colspan="3">public add($interval)</td>
        </tr>
        <tr>
            <td colspan="3">public sub($interval)</td>
        </tr>
        <tr>
            <td colspan="3">public getTimezone()</td>
        </tr>
        <tr>
            <td colspan="3">public setTimezone($timezone)</td>
        </tr>
        <tr>
            <td colspan="3">public getOffset()</td>
        </tr>
        <tr>
            <td colspan="3">public setTime($hour, $minute, $second)</td>
        </tr>
        <tr>
            <td colspan="3">public setDate($year, $month, $day)</td>
        </tr>
        <tr>
            <td colspan="3">public setISODate($year, $week, $day)</td>
        </tr>
        <tr>
            <td colspan="3">public setTimestamp($unixtimestamp)</td>
        </tr>
        <tr>
            <td colspan="3">public getTimestamp()</td>
        </tr>
        <tr>
            <td colspan="3">public diff($object, $absolute)</td>
        </tr>
    </tbody>
</table>