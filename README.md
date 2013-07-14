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
array(58)
|              "LC_MESSAGES": string(11) "fr_FR.UTF-8"
|                     "LANG": string(11) "fr_FR.UTF-8"
|                  "DISPLAY": string(2) ":0"
|                    "SHLVL": string(1) "1"
|                  "LOGNAME": string(9) "rlittolff"
|                 "XDG_VTNR": string(1) "7"
|                      "PWD": string(30) "/home/rlittolff/dev/DumperTest"
|          "MOZ_PLUGIN_PATH": string(24) "/usr/lib/mozilla/plugins"
|               "XAUTHORITY": string(27) "/home/rlittolff/.Xauthority"
|     "DESKTOP_AUTOSTART_ID": string(46) "10f86fdf463a7038813739577887426300000008590006"
|                "COLORTERM": string(14) "gnome-terminal"
|           "XDG_SESSION_ID": string(1) "1"
|                "JAVA_HOME": string(31) "/usr/lib/jvm/java-7-openjdk/jre"
|          "DESKTOP_SESSION": string(21) "/usr/bin/mate-session"
|     "MATE_KEYRING_CONTROL": string(19) "/tmp/keyring-FMtBnT"
|  "MATE_DESKTOP_SESSION_ID": string(18) "this-is-deprecated"
| "DBUS_SESSION_BUS_ADDRESS": string(72) "unix:abstract=/tmp/dbus-zcTyLcOLol,guid=bba59691e442470f12bc52cb51e4ee9a"
|          "TERMINATOR_UUID": string(45) "urn:uuid:e437e22b-63e6-4900-a11b-d12923db058f"
|                        "_": string(12) "/usr/bin/php"
|        "AUTOJUMP_DATA_DIR": string(37) "/home/rlittolff/.local/share/autojump"
|       "XDG_SESSION_COOKIE": string(60) "dc0cbc75b3cb4c17ae58385fb4568ad8-1373957785.974977-655903641"
|                   "OLDPWD": string(19) "/home/rlittolff/dev"
|                    "SHELL": string(8) "/bin/zsh"
|                 "WINDOWID": string(8) "52428803"
|                     "TERM": string(5) "xterm"
|          "SESSION_MANAGER": string(57) "local/mya:@/tmp/.ICE-unix/859,unix/mya:/tmp/.ICE-unix/859"
|            "SSH_AUTH_SOCK": string(23) "/tmp/keyring-FMtBnT/ssh"
|                     "PATH": string(191) "/usr/local/bin:/usr/local/sbin:/home/rlittolff/bin:/home/rlittolff/pear/bin:/home/rlittolff/.gem/ruby/2.0.0/bin:/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin:/usr/bin/core_perl"
|                     "HOME": string(15) "/home/rlittolff"
|                 "XDG_SEAT": string(5) "seat0"
|          "XDG_RUNTIME_DIR": string(14) "/run/user/1000"
|           "GPG_AGENT_INFO": string(27) "/tmp/keyring-FMtBnT/gpg:0:1"
|                     "USER": string(9) "rlittolff"
|                   "EDITOR": string(3) "vim"
|                 "MANPAGER": string(9) "less -FRX"
|          "LESS_TERMCAP_mb": string(8) ""
|          "LESS_TERMCAP_md": string(13) ""
|          "LESS_TERMCAP_me": string(4) ""
|          "LESS_TERMCAP_se": string(4) ""
|          "LESS_TERMCAP_so": string(11) ""
|          "LESS_TERMCAP_ue": string(4) ""
|          "LESS_TERMCAP_us": string(12) ""
|             "GREP_OPTIONS": string(12) "--color=auto"
|               "GREP_COLOR": string(4) "1;32"
|                    "PAGER": string(4) "less"
|                     "LESS": string(2) "-R"
|                 "LC_CTYPE": string(11) "fr_FR.UTF-8"
|                 "LSCOLORS": string(22) "Gxfxcxdxbxegedabagacad"
|                "NODE_PATH": string(21) "/usr/lib/node_modules"
|                 "PHP_SELF": string(9) "index.php"
|              "SCRIPT_NAME": string(9) "index.php"
|          "SCRIPT_FILENAME": string(9) "index.php"
|          "PATH_TRANSLATED": string(9) "index.php"
|            "DOCUMENT_ROOT": string(0) ""
|       "REQUEST_TIME_FLOAT": float(1373964176.3316)
|             "REQUEST_TIME": integer(1373964176)
|                     "argv": array(1)
|                             | 0: string(9) "index.php"
|                     "argc": integer(1)

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
            <th>"UNIQUE_ID"</th>
            <td>
                string(24) "UeUH-H8AAQEAAAg2T@QAAAAA"
            </td>
        </tr>
        <tr>
            <th>"HTTP_HOST"</th>
            <td>
                string(9) "localhost"
            </td>
        </tr>
        <tr>
            <th>"HTTP_CONNECTION"</th>
            <td>
                string(10) "keep-alive"
            </td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT"</th>
            <td>
                string(63) "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
            </td>
        </tr>
        <tr>
            <th>"HTTP_USER_AGENT"</th>
            <td>
                string(104) "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36"
            </td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT_ENCODING"</th>
            <td>
                string(17) "gzip,deflate,sdch"
            </td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT_LANGUAGE"</th>
            <td>
                string(23) "fr,en-US;q=0.8,en;q=0.6"
            </td>
        </tr>
        <tr>
            <th>"PATH"</th>
            <td>
                string(49) "/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin"
            </td>
        </tr>
        <tr>
            <th>"SERVER_SIGNATURE"</th>
            <td>
                string(115) "<address>Apache/2.2.24 (Unix) mod_ssl/2.2.24 OpenSSL/1.0.1e DAV/2 PHP/5.4.17 Server at localhost Port 80</address>
"
            </td>
        </tr>
        <tr>
            <th>"SERVER_SOFTWARE"</th>
            <td>
                string(67) "Apache/2.2.24 (Unix) mod_ssl/2.2.24 OpenSSL/1.0.1e DAV/2 PHP/5.4.17"
            </td>
        </tr>
        <tr>
            <th>"SERVER_NAME"</th>
            <td>
                string(9) "localhost"
            </td>
        </tr>
        <tr>
            <th>"SERVER_ADDR"</th>
            <td>
                string(3) "::1"
            </td>
        </tr>
        <tr>
            <th>"SERVER_PORT"</th>
            <td>
                string(2) "80"
            </td>
        </tr>
        <tr>
            <th>"REMOTE_ADDR"</th>
            <td>
                string(3) "::1"
            </td>
        </tr>
        <tr>
            <th>"DOCUMENT_ROOT"</th>
            <td>
                string(19) "/home/rlittolff/dev"
            </td>
        </tr>
        <tr>
            <th>"SERVER_ADMIN"</th>
            <td>
                string(16) "renaud@atipik.fr"
            </td>
        </tr>
        <tr>
            <th>"SCRIPT_FILENAME"</th>
            <td>
                string(40) "/home/rlittolff/dev/DumperTest/index.php"
            </td>
        </tr>
        <tr>
            <th>"REMOTE_PORT"</th>
            <td>
                string(5) "36846"
            </td>
        </tr>
        <tr>
            <th>"GATEWAY_INTERFACE"</th>
            <td>
                string(7) "CGI/1.1"
            </td>
        </tr>
        <tr>
            <th>"SERVER_PROTOCOL"</th>
            <td>
                string(8) "HTTP/1.1"
            </td>
        </tr>
        <tr>
            <th>"REQUEST_METHOD"</th>
            <td>
                string(3) "GET"
            </td>
        </tr>
        <tr>
            <th>"QUERY_STRING"</th>
            <td>
                string(0) ""
            </td>
        </tr>
        <tr>
            <th>"REQUEST_URI"</th>
            <td>
                string(12) "/DumperTest/"
            </td>
        </tr>
        <tr>
            <th>"SCRIPT_NAME"</th>
            <td>
                string(21) "/DumperTest/index.php"
            </td>
        </tr>
        <tr>
            <th>"PHP_SELF"</th>
            <td>
                string(21) "/DumperTest/index.php"
            </td>
        </tr>
        <tr>
            <th>"REQUEST_TIME_FLOAT"</th>
            <td>
                float(1373964284.083)
            </td>
        </tr>
        <tr>
            <th>"REQUEST_TIME"</th>
            <td>
                integer(1373964284)
            </td>
        </tr>
    </tbody>
</table>

<table class="dumper object">
    <thead>
        <tr>
            <th>object DateTime<th>
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
                            string(13) "Y-m-d\TH:i:sP"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">COOKIE</td>
                        <td class="value">
                            string(16) "l, d-M-y H:i:s T"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">ISO8601</td>
                        <td class="value">
                            string(13) "Y-m-d\TH:i:sO"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC822</td>
                        <td class="value">
                            string(16) "D, d M y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC850</td>
                        <td class="value">
                            string(16) "l, d-M-y H:i:s T"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC1036</td>
                        <td class="value">
                            string(16) "D, d M y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC1123</td>
                        <td class="value">
                            string(16) "D, d M Y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC2822</td>
                        <td class="value">
                            string(16) "D, d M Y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC3339</td>
                        <td class="value">
                            string(13) "Y-m-d\TH:i:sP"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RSS</td>
                        <td class="value">
                            string(16) "D, d M Y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">W3C</td>
                        <td class="value">
                            string(13) "Y-m-d\TH:i:sP"
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
```


<table class="dumper array">
    <thead>
        <tr>
            <th colspan="2">array(27)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>"UNIQUE_ID"</th>
            <td>
                string(24) "UeUH-H8AAQEAAAg2T@QAAAAA"
            </td>
        </tr>
        <tr>
            <th>"HTTP_HOST"</th>
            <td>
                string(9) "localhost"
            </td>
        </tr>
        <tr>
            <th>"HTTP_CONNECTION"</th>
            <td>
                string(10) "keep-alive"
            </td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT"</th>
            <td>
                string(63) "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
            </td>
        </tr>
        <tr>
            <th>"HTTP_USER_AGENT"</th>
            <td>
                string(104) "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36"
            </td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT_ENCODING"</th>
            <td>
                string(17) "gzip,deflate,sdch"
            </td>
        </tr>
        <tr>
            <th>"HTTP_ACCEPT_LANGUAGE"</th>
            <td>
                string(23) "fr,en-US;q=0.8,en;q=0.6"
            </td>
        </tr>
        <tr>
            <th>"PATH"</th>
            <td>
                string(49) "/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin"
            </td>
        </tr>
        <tr>
            <th>"SERVER_SIGNATURE"</th>
            <td>
                string(115) "<address>Apache/2.2.24 (Unix) mod_ssl/2.2.24 OpenSSL/1.0.1e DAV/2 PHP/5.4.17 Server at localhost Port 80</address>
"
            </td>
        </tr>
        <tr>
            <th>"SERVER_SOFTWARE"</th>
            <td>
                string(67) "Apache/2.2.24 (Unix) mod_ssl/2.2.24 OpenSSL/1.0.1e DAV/2 PHP/5.4.17"
            </td>
        </tr>
        <tr>
            <th>"SERVER_NAME"</th>
            <td>
                string(9) "localhost"
            </td>
        </tr>
        <tr>
            <th>"SERVER_ADDR"</th>
            <td>
                string(3) "::1"
            </td>
        </tr>
        <tr>
            <th>"SERVER_PORT"</th>
            <td>
                string(2) "80"
            </td>
        </tr>
        <tr>
            <th>"REMOTE_ADDR"</th>
            <td>
                string(3) "::1"
            </td>
        </tr>
        <tr>
            <th>"DOCUMENT_ROOT"</th>
            <td>
                string(19) "/home/rlittolff/dev"
            </td>
        </tr>
        <tr>
            <th>"SERVER_ADMIN"</th>
            <td>
                string(16) "renaud@atipik.fr"
            </td>
        </tr>
        <tr>
            <th>"SCRIPT_FILENAME"</th>
            <td>
                string(40) "/home/rlittolff/dev/DumperTest/index.php"
            </td>
        </tr>
        <tr>
            <th>"REMOTE_PORT"</th>
            <td>
                string(5) "36846"
            </td>
        </tr>
        <tr>
            <th>"GATEWAY_INTERFACE"</th>
            <td>
                string(7) "CGI/1.1"
            </td>
        </tr>
        <tr>
            <th>"SERVER_PROTOCOL"</th>
            <td>
                string(8) "HTTP/1.1"
            </td>
        </tr>
        <tr>
            <th>"REQUEST_METHOD"</th>
            <td>
                string(3) "GET"
            </td>
        </tr>
        <tr>
            <th>"QUERY_STRING"</th>
            <td>
                string(0) ""
            </td>
        </tr>
        <tr>
            <th>"REQUEST_URI"</th>
            <td>
                string(12) "/DumperTest/"
            </td>
        </tr>
        <tr>
            <th>"SCRIPT_NAME"</th>
            <td>
                string(21) "/DumperTest/index.php"
            </td>
        </tr>
        <tr>
            <th>"PHP_SELF"</th>
            <td>
                string(21) "/DumperTest/index.php"
            </td>
        </tr>
        <tr>
            <th>"REQUEST_TIME_FLOAT"</th>
            <td>
                float(1373964284.083)
            </td>
        </tr>
        <tr>
            <th>"REQUEST_TIME"</th>
            <td>
                integer(1373964284)
            </td>
        </tr>
    </tbody>
</table>

<table class="dumper object">
    <thead>
        <tr>
            <th>object DateTime<th>
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
                            string(13) "Y-m-d\TH:i:sP"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">COOKIE</td>
                        <td class="value">
                            string(16) "l, d-M-y H:i:s T"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">ISO8601</td>
                        <td class="value">
                            string(13) "Y-m-d\TH:i:sO"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC822</td>
                        <td class="value">
                            string(16) "D, d M y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC850</td>
                        <td class="value">
                            string(16) "l, d-M-y H:i:s T"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC1036</td>
                        <td class="value">
                            string(16) "D, d M y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC1123</td>
                        <td class="value">
                            string(16) "D, d M Y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC2822</td>
                        <td class="value">
                            string(16) "D, d M Y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RFC3339</td>
                        <td class="value">
                            string(13) "Y-m-d\TH:i:sP"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">RSS</td>
                        <td class="value">
                            string(16) "D, d M Y H:i:s O"
                        </td>
                    </tr>
                    <tr>
                        <td class="name">W3C</td>
                        <td class="value">
                            string(13) "Y-m-d\TH:i:sP"
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