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

dump($_SERVER, new DateTime);
```

### CLI

Here is an example of cli output:

```
array(58)
|              "LC_MESSAGES": string(11) "fr_FR.UTF-8"
|                     "LANG": string(11) "fr_FR.UTF-8"
|                  "DISPLAY": string(2) ":0"
|                    "SHLVL": string(1) "1"
|                  "LOGNAME": string(9) "rlittolff"
|                 "XDG_VTNR": string(1) "7"
|                      "PWD": string(26) "/home/rlittolff/dev/Dumper"
|          "MOZ_PLUGIN_PATH": string(24) "/usr/lib/mozilla/plugins"
|               "XAUTHORITY": string(27) "/home/rlittolff/.Xauthority"
|     "DESKTOP_AUTOSTART_ID": string(48) "10929648d715c91b6e137465067499818100000008580006"
|                "COLORTERM": string(14) "gnome-terminal"
|           "XDG_SESSION_ID": string(2) "c1"
|                "JAVA_HOME": string(31) "/usr/lib/jvm/java-7-openjdk/jre"
|          "DESKTOP_SESSION": string(21) "/usr/bin/mate-session"
|     "MATE_KEYRING_CONTROL": string(19) "/tmp/keyring-36nC8W"
|  "MATE_DESKTOP_SESSION_ID": string(18) "this-is-deprecated"
| "DBUS_SESSION_BUS_ADDRESS": string(72) "unix:abstract=/tmp/dbus-2WCetVs9VN,guid=602e8159a7ab39980813ad1051ef8132"
|          "TERMINATOR_UUID": string(45) "urn:uuid:9d8da1f3-b198-4adc-be5a-baa842909276"
|                        "_": string(47) "/home/rlittolff/dev/Dumper/./bin/generateReadme"
|        "AUTOJUMP_DATA_DIR": string(37) "/home/rlittolff/.local/share/autojump"
|       "XDG_SESSION_COOKIE": string(61) "14e1cba1928f4b8cba34619db23f6dd3-1374650674.158265-1724706027"
|                   "OLDPWD": string(30) "/home/rlittolff/dev/DumperTest"
|                    "SHELL": string(8) "/bin/zsh"
|                 "WINDOWID": string(8) "58720259"
|                     "TERM": string(5) "xterm"
|          "SESSION_MANAGER": string(57) "local/mya:@/tmp/.ICE-unix/858,unix/mya:/tmp/.ICE-unix/858"
|            "SSH_AUTH_SOCK": string(23) "/tmp/keyring-36nC8W/ssh"
|                     "PATH": string(191) "/usr/local/bin:/usr/local/sbin:/home/rlittolff/bin:/home/rlittolff/pear/bin:/home/rlittolff/.gem/ruby/2.0.0/bin:/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin:/usr/bin/core_perl"
|                     "HOME": string(15) "/home/rlittolff"
|                 "XDG_SEAT": string(5) "seat0"
|          "XDG_RUNTIME_DIR": string(14) "/run/user/1000"
|           "GPG_AGENT_INFO": string(27) "/tmp/keyring-36nC8W/gpg:0:1"
|                     "USER": string(9) "rlittolff"
|                   "EDITOR": string(3) "vim"
|                 "MANPAGER": string(9) "less -FRX"
|          "LESS_TERMCAP_mb": string(8) "[01;31m"
|          "LESS_TERMCAP_md": string(13) "[01;38;5;74m"
|          "LESS_TERMCAP_me": string(4) "[0m"
|          "LESS_TERMCAP_se": string(4) "[0m"
|          "LESS_TERMCAP_so": string(11) "[38;5;246m"
|          "LESS_TERMCAP_ue": string(4) "[0m"
|          "LESS_TERMCAP_us": string(12) "[04;33;146m"
|             "GREP_OPTIONS": string(12) "--color=auto"
|               "GREP_COLOR": string(4) "1;32"
|                    "PAGER": string(4) "less"
|                     "LESS": string(2) "-R"
|                 "LC_CTYPE": string(11) "fr_FR.UTF-8"
|                 "LSCOLORS": string(22) "Gxfxcxdxbxegedabagacad"
|                "NODE_PATH": string(21) "/usr/lib/node_modules"
|                 "PHP_SELF": string(20) "./bin/generateReadme"
|              "SCRIPT_NAME": string(20) "./bin/generateReadme"
|          "SCRIPT_FILENAME": string(20) "./bin/generateReadme"
|          "PATH_TRANSLATED": string(20) "./bin/generateReadme"
|            "DOCUMENT_ROOT": string(0) ""
|       "REQUEST_TIME_FLOAT": float(1374659814.8354)
|             "REQUEST_TIME": integer(1374659814)
|                     "argv": array(1)
|                             | 0: string(20) "./bin/generateReadme"
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

```html
<table class="dumper array">
    <thead>
        <tr>
            <th colspan="2">array(58)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>"LC_MESSAGES"</th>
            <td>
                string(11) "fr_FR.UTF-8"
            </td>
        </tr>
        <tr>
            <th>"LANG"</th>
            <td>
                string(11) "fr_FR.UTF-8"
            </td>
        </tr>
        <tr>
            <th>"DISPLAY"</th>
            <td>
                string(2) ":0"
            </td>
        </tr>
        <tr>
            <th>"SHLVL"</th>
            <td>
                string(1) "1"
            </td>
        </tr>
        <tr>
            <th>"LOGNAME"</th>
            <td>
                string(9) "rlittolff"
            </td>
        </tr>
        <tr>
            <th>"XDG_VTNR"</th>
            <td>
                string(1) "7"
            </td>
        </tr>
        <tr>
            <th>"PWD"</th>
            <td>
                string(26) "/home/rlittolff/dev/Dumper"
            </td>
        </tr>
        <tr>
            <th>"MOZ_PLUGIN_PATH"</th>
            <td>
                string(24) "/usr/lib/mozilla/plugins"
            </td>
        </tr>
        <tr>
            <th>"XAUTHORITY"</th>
            <td>
                string(27) "/home/rlittolff/.Xauthority"
            </td>
        </tr>
        <tr>
            <th>"DESKTOP_AUTOSTART_ID"</th>
            <td>
                string(48) "10929648d715c91b6e137465067499818100000008580006"
            </td>
        </tr>
        <tr>
            <th>"COLORTERM"</th>
            <td>
                string(14) "gnome-terminal"
            </td>
        </tr>
        <tr>
            <th>"XDG_SESSION_ID"</th>
            <td>
                string(2) "c1"
            </td>
        </tr>
        <tr>
            <th>"JAVA_HOME"</th>
            <td>
                string(31) "/usr/lib/jvm/java-7-openjdk/jre"
            </td>
        </tr>
        <tr>
            <th>"DESKTOP_SESSION"</th>
            <td>
                string(21) "/usr/bin/mate-session"
            </td>
        </tr>
        <tr>
            <th>"MATE_KEYRING_CONTROL"</th>
            <td>
                string(19) "/tmp/keyring-36nC8W"
            </td>
        </tr>
        <tr>
            <th>"MATE_DESKTOP_SESSION_ID"</th>
            <td>
                string(18) "this-is-deprecated"
            </td>
        </tr>
        <tr>
            <th>"DBUS_SESSION_BUS_ADDRESS"</th>
            <td>
                string(72) "unix:abstract=/tmp/dbus-2WCetVs9VN,guid=602e8159a7ab39980813ad1051ef8132"
            </td>
        </tr>
        <tr>
            <th>"TERMINATOR_UUID"</th>
            <td>
                string(45) "urn:uuid:9d8da1f3-b198-4adc-be5a-baa842909276"
            </td>
        </tr>
        <tr>
            <th>"_"</th>
            <td>
                string(47) "/home/rlittolff/dev/Dumper/./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"AUTOJUMP_DATA_DIR"</th>
            <td>
                string(37) "/home/rlittolff/.local/share/autojump"
            </td>
        </tr>
        <tr>
            <th>"XDG_SESSION_COOKIE"</th>
            <td>
                string(61) "14e1cba1928f4b8cba34619db23f6dd3-1374650674.158265-1724706027"
            </td>
        </tr>
        <tr>
            <th>"OLDPWD"</th>
            <td>
                string(30) "/home/rlittolff/dev/DumperTest"
            </td>
        </tr>
        <tr>
            <th>"SHELL"</th>
            <td>
                string(8) "/bin/zsh"
            </td>
        </tr>
        <tr>
            <th>"WINDOWID"</th>
            <td>
                string(8) "58720259"
            </td>
        </tr>
        <tr>
            <th>"TERM"</th>
            <td>
                string(5) "xterm"
            </td>
        </tr>
        <tr>
            <th>"SESSION_MANAGER"</th>
            <td>
                string(57) "local/mya:@/tmp/.ICE-unix/858,unix/mya:/tmp/.ICE-unix/858"
            </td>
        </tr>
        <tr>
            <th>"SSH_AUTH_SOCK"</th>
            <td>
                string(23) "/tmp/keyring-36nC8W/ssh"
            </td>
        </tr>
        <tr>
            <th>"PATH"</th>
            <td>
                string(191) "/usr/local/bin:/usr/local/sbin:/home/rlittolff/bin:/home/rlittolff/pear/bin:/home/rlittolff/.gem/ruby/2.0.0/bin:/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin:/usr/bin/core_perl"
            </td>
        </tr>
        <tr>
            <th>"HOME"</th>
            <td>
                string(15) "/home/rlittolff"
            </td>
        </tr>
        <tr>
            <th>"XDG_SEAT"</th>
            <td>
                string(5) "seat0"
            </td>
        </tr>
        <tr>
            <th>"XDG_RUNTIME_DIR"</th>
            <td>
                string(14) "/run/user/1000"
            </td>
        </tr>
        <tr>
            <th>"GPG_AGENT_INFO"</th>
            <td>
                string(27) "/tmp/keyring-36nC8W/gpg:0:1"
            </td>
        </tr>
        <tr>
            <th>"USER"</th>
            <td>
                string(9) "rlittolff"
            </td>
        </tr>
        <tr>
            <th>"EDITOR"</th>
            <td>
                string(3) "vim"
            </td>
        </tr>
        <tr>
            <th>"MANPAGER"</th>
            <td>
                string(9) "less -FRX"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_mb"</th>
            <td>
                string(8) "[01;31m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_md"</th>
            <td>
                string(13) "[01;38;5;74m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_me"</th>
            <td>
                string(4) "[0m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_se"</th>
            <td>
                string(4) "[0m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_so"</th>
            <td>
                string(11) "[38;5;246m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_ue"</th>
            <td>
                string(4) "[0m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_us"</th>
            <td>
                string(12) "[04;33;146m"
            </td>
        </tr>
        <tr>
            <th>"GREP_OPTIONS"</th>
            <td>
                string(12) "--color=auto"
            </td>
        </tr>
        <tr>
            <th>"GREP_COLOR"</th>
            <td>
                string(4) "1;32"
            </td>
        </tr>
        <tr>
            <th>"PAGER"</th>
            <td>
                string(4) "less"
            </td>
        </tr>
        <tr>
            <th>"LESS"</th>
            <td>
                string(2) "-R"
            </td>
        </tr>
        <tr>
            <th>"LC_CTYPE"</th>
            <td>
                string(11) "fr_FR.UTF-8"
            </td>
        </tr>
        <tr>
            <th>"LSCOLORS"</th>
            <td>
                string(22) "Gxfxcxdxbxegedabagacad"
            </td>
        </tr>
        <tr>
            <th>"NODE_PATH"</th>
            <td>
                string(21) "/usr/lib/node_modules"
            </td>
        </tr>
        <tr>
            <th>"PHP_SELF"</th>
            <td>
                string(20) "./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"SCRIPT_NAME"</th>
            <td>
                string(20) "./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"SCRIPT_FILENAME"</th>
            <td>
                string(20) "./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"PATH_TRANSLATED"</th>
            <td>
                string(20) "./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"DOCUMENT_ROOT"</th>
            <td>
                string(0) ""
            </td>
        </tr>
        <tr>
            <th>"REQUEST_TIME_FLOAT"</th>
            <td>
                float(1374659814.8354)
            </td>
        </tr>
        <tr>
            <th>"REQUEST_TIME"</th>
            <td>
                integer(1374659814)
            </td>
        </tr>
        <tr>
            <th>"argv"</th>
            <td>
                <table class="dumper array">
                    <thead>
                        <tr>
                            <th colspan="2">array(1)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>0</th>
                            <td>
                                string(20) "./bin/generateReadme"
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <th>"argc"</th>
            <td>
                integer(1)
            </td>
        </tr>
    </tbody>
</table>

<table class="dumper object">
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
            <th colspan="2">array(58)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>"LC_MESSAGES"</th>
            <td>
                string(11) "fr_FR.UTF-8"
            </td>
        </tr>
        <tr>
            <th>"LANG"</th>
            <td>
                string(11) "fr_FR.UTF-8"
            </td>
        </tr>
        <tr>
            <th>"DISPLAY"</th>
            <td>
                string(2) ":0"
            </td>
        </tr>
        <tr>
            <th>"SHLVL"</th>
            <td>
                string(1) "1"
            </td>
        </tr>
        <tr>
            <th>"LOGNAME"</th>
            <td>
                string(9) "rlittolff"
            </td>
        </tr>
        <tr>
            <th>"XDG_VTNR"</th>
            <td>
                string(1) "7"
            </td>
        </tr>
        <tr>
            <th>"PWD"</th>
            <td>
                string(26) "/home/rlittolff/dev/Dumper"
            </td>
        </tr>
        <tr>
            <th>"MOZ_PLUGIN_PATH"</th>
            <td>
                string(24) "/usr/lib/mozilla/plugins"
            </td>
        </tr>
        <tr>
            <th>"XAUTHORITY"</th>
            <td>
                string(27) "/home/rlittolff/.Xauthority"
            </td>
        </tr>
        <tr>
            <th>"DESKTOP_AUTOSTART_ID"</th>
            <td>
                string(48) "10929648d715c91b6e137465067499818100000008580006"
            </td>
        </tr>
        <tr>
            <th>"COLORTERM"</th>
            <td>
                string(14) "gnome-terminal"
            </td>
        </tr>
        <tr>
            <th>"XDG_SESSION_ID"</th>
            <td>
                string(2) "c1"
            </td>
        </tr>
        <tr>
            <th>"JAVA_HOME"</th>
            <td>
                string(31) "/usr/lib/jvm/java-7-openjdk/jre"
            </td>
        </tr>
        <tr>
            <th>"DESKTOP_SESSION"</th>
            <td>
                string(21) "/usr/bin/mate-session"
            </td>
        </tr>
        <tr>
            <th>"MATE_KEYRING_CONTROL"</th>
            <td>
                string(19) "/tmp/keyring-36nC8W"
            </td>
        </tr>
        <tr>
            <th>"MATE_DESKTOP_SESSION_ID"</th>
            <td>
                string(18) "this-is-deprecated"
            </td>
        </tr>
        <tr>
            <th>"DBUS_SESSION_BUS_ADDRESS"</th>
            <td>
                string(72) "unix:abstract=/tmp/dbus-2WCetVs9VN,guid=602e8159a7ab39980813ad1051ef8132"
            </td>
        </tr>
        <tr>
            <th>"TERMINATOR_UUID"</th>
            <td>
                string(45) "urn:uuid:9d8da1f3-b198-4adc-be5a-baa842909276"
            </td>
        </tr>
        <tr>
            <th>"_"</th>
            <td>
                string(47) "/home/rlittolff/dev/Dumper/./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"AUTOJUMP_DATA_DIR"</th>
            <td>
                string(37) "/home/rlittolff/.local/share/autojump"
            </td>
        </tr>
        <tr>
            <th>"XDG_SESSION_COOKIE"</th>
            <td>
                string(61) "14e1cba1928f4b8cba34619db23f6dd3-1374650674.158265-1724706027"
            </td>
        </tr>
        <tr>
            <th>"OLDPWD"</th>
            <td>
                string(30) "/home/rlittolff/dev/DumperTest"
            </td>
        </tr>
        <tr>
            <th>"SHELL"</th>
            <td>
                string(8) "/bin/zsh"
            </td>
        </tr>
        <tr>
            <th>"WINDOWID"</th>
            <td>
                string(8) "58720259"
            </td>
        </tr>
        <tr>
            <th>"TERM"</th>
            <td>
                string(5) "xterm"
            </td>
        </tr>
        <tr>
            <th>"SESSION_MANAGER"</th>
            <td>
                string(57) "local/mya:@/tmp/.ICE-unix/858,unix/mya:/tmp/.ICE-unix/858"
            </td>
        </tr>
        <tr>
            <th>"SSH_AUTH_SOCK"</th>
            <td>
                string(23) "/tmp/keyring-36nC8W/ssh"
            </td>
        </tr>
        <tr>
            <th>"PATH"</th>
            <td>
                string(191) "/usr/local/bin:/usr/local/sbin:/home/rlittolff/bin:/home/rlittolff/pear/bin:/home/rlittolff/.gem/ruby/2.0.0/bin:/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin:/usr/bin/core_perl"
            </td>
        </tr>
        <tr>
            <th>"HOME"</th>
            <td>
                string(15) "/home/rlittolff"
            </td>
        </tr>
        <tr>
            <th>"XDG_SEAT"</th>
            <td>
                string(5) "seat0"
            </td>
        </tr>
        <tr>
            <th>"XDG_RUNTIME_DIR"</th>
            <td>
                string(14) "/run/user/1000"
            </td>
        </tr>
        <tr>
            <th>"GPG_AGENT_INFO"</th>
            <td>
                string(27) "/tmp/keyring-36nC8W/gpg:0:1"
            </td>
        </tr>
        <tr>
            <th>"USER"</th>
            <td>
                string(9) "rlittolff"
            </td>
        </tr>
        <tr>
            <th>"EDITOR"</th>
            <td>
                string(3) "vim"
            </td>
        </tr>
        <tr>
            <th>"MANPAGER"</th>
            <td>
                string(9) "less -FRX"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_mb"</th>
            <td>
                string(8) "[01;31m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_md"</th>
            <td>
                string(13) "[01;38;5;74m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_me"</th>
            <td>
                string(4) "[0m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_se"</th>
            <td>
                string(4) "[0m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_so"</th>
            <td>
                string(11) "[38;5;246m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_ue"</th>
            <td>
                string(4) "[0m"
            </td>
        </tr>
        <tr>
            <th>"LESS_TERMCAP_us"</th>
            <td>
                string(12) "[04;33;146m"
            </td>
        </tr>
        <tr>
            <th>"GREP_OPTIONS"</th>
            <td>
                string(12) "--color=auto"
            </td>
        </tr>
        <tr>
            <th>"GREP_COLOR"</th>
            <td>
                string(4) "1;32"
            </td>
        </tr>
        <tr>
            <th>"PAGER"</th>
            <td>
                string(4) "less"
            </td>
        </tr>
        <tr>
            <th>"LESS"</th>
            <td>
                string(2) "-R"
            </td>
        </tr>
        <tr>
            <th>"LC_CTYPE"</th>
            <td>
                string(11) "fr_FR.UTF-8"
            </td>
        </tr>
        <tr>
            <th>"LSCOLORS"</th>
            <td>
                string(22) "Gxfxcxdxbxegedabagacad"
            </td>
        </tr>
        <tr>
            <th>"NODE_PATH"</th>
            <td>
                string(21) "/usr/lib/node_modules"
            </td>
        </tr>
        <tr>
            <th>"PHP_SELF"</th>
            <td>
                string(20) "./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"SCRIPT_NAME"</th>
            <td>
                string(20) "./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"SCRIPT_FILENAME"</th>
            <td>
                string(20) "./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"PATH_TRANSLATED"</th>
            <td>
                string(20) "./bin/generateReadme"
            </td>
        </tr>
        <tr>
            <th>"DOCUMENT_ROOT"</th>
            <td>
                string(0) ""
            </td>
        </tr>
        <tr>
            <th>"REQUEST_TIME_FLOAT"</th>
            <td>
                float(1374659814.8354)
            </td>
        </tr>
        <tr>
            <th>"REQUEST_TIME"</th>
            <td>
                integer(1374659814)
            </td>
        </tr>
        <tr>
            <th>"argv"</th>
            <td>
                <table class="dumper array">
                    <thead>
                        <tr>
                            <th colspan="2">array(1)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>0</th>
                            <td>
                                string(20) "./bin/generateReadme"
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <th>"argc"</th>
            <td>
                integer(1)
            </td>
        </tr>
    </tbody>
</table>

<table class="dumper object">
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

