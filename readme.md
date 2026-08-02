```
____   _________________________   ________ ___________
\   \ /   /\_   _____/\______   \ /  _____/ \_   _____/
 \   Y   /  |    __)_  |       _//   \  ___  |    __)_ 
  \     /   |        \ |    |   \\    \_\  \ |        \ 2026 VERGE
   \___/   /_______  / |____|_  / \______  //_______  /
                   \/         \/         \/         \/ 
```
# PHP-Verge
<a href="https://github.com/vergecurrency/php-verge/actions/workflows/php.yml">
<img src="https://github.com/vergecurrency/php-verge/actions/workflows/php.yml/badge.svg">
</a>
<br>
A basic PHP library for talking to a `verged` daemon from your Verge project.
It is continuously tested against PHP 8.1–8.5 and a real Verge Core 26.7 daemon.
For a full list of available rpc commands issue the _help_ command in your VERGEd.

**Proud to be completely PSR compliant!**

## Requirements

Requires PHP 8.1 or newer with the cURL and JSON extensions, plus
**Composer** [https://getcomposer.org/](https://getcomposer.org/).

Requires **VERGEd** to already be installed and running on your local server or reachable by your server.  

Get the VERGEd source from: https://github.com/vergecurrency/verge
and follow the instructions for compiling the verged (daemon) or download the appropriate bundle for your platform in the releases tab

## Usage:
Install the library:

```shell
composer require vergecurrency/verge-rpc
```

Example Usage (see example.php for additional coverage):

```php
// Composer Autoloader ( PSR-4 )
require_once 'vendor/autoload.php';

// Demo RPC configuration
$config = [
    'user' => 'vergerpcuser',
    'pass' => 'rpcpassword',
    'host' => '127.0.0.1',
    'port' => 20102,
];

// Initiate connection
$verge = new Verge\RPC(
    sprintf('http://%s:%s@%s:%s/',
        $config['user'],
        $config['pass'],
        $config['host'],
        $config['port']
    )
);

// Set a wallet label.
$label = 'Positivism';

// Generate a new verge address.
$address = $verge->getnewaddress($label);

```

The included `example.php` reads `VERGE_RPC_USER`, `VERGE_RPC_PASSWORD`,
`VERGE_RPC_HOST`, `VERGE_RPC_PORT`, and optional `VERGE_RPC_DEBUG` environment
variables. See the GitHub Actions workflow for a complete Verge Core 26.7
regtest setup.

**PHP-Verge created with <33 by:** [@Positivism](https://github.com/Positivism)
