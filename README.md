# Dumper

A pretty variable dumper for HTML & cli.


## Installation with composer

```json
{
    "require": {
        "mattlab/dumper": "dev-master"
    }
}
```

In most of the cases you don't need AtoumBundle in your production environment.

```json
{
    "require-dev": {
        "mattlab/dumper": "dev-master"
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

    dump($_SERVER);
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
```