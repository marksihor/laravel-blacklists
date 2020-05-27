# laravel-blacklists

The package allows you to make blacklists with specified types and values.

## Installing

```shell
$ composer require marksihor/laravel-blacklists -vvv
```

## Usage

### Use trait in Model you wish to use blacklist on

```php
<?php

namespace App;

use MarksIhor\LaravelBlacklists\Blacklistable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Blacklistable;
    <...>
}
```

### Usage examples

```php
$user->addToBlacklist('user', 7); // add to blacklist
$user->removeFromBlacklist('user', 5); // remove from blacklist
$user->checkIfInBlacklist('user', 5); // check if in blacklist
$user->getBlacklists(); // view all blacklists
```

The package uses Cache facade to cache all queries.

## License

MIT