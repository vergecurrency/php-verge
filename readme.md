```
____   _________________________   ________ ___________
\   \ /   /\_   _____/\______   \ /  _____/ \_   _____/
 \   Y   /  |    __)_  |       _//   \  ___  |    __)_ 
  \     /   |        \ |    |   \\    \_\  \ |        \ 2025 VERGE
   \___/   /_______  / |____|_  / \______  //_______  /
                   \/         \/         \/         \/ 
```
# PHP-Verge

A basic PHP library to talk to a VERGEd daemon to get you started in your VERGE project!
Proper rpc usage with basic examples given to assist you in your development.
For a full list of available rpc commands issue the _help_ command in your VERGEd.

**Proud to be completely PSR compliant!**

## Requirements

Requires **Composer** [https://getcomposer.org/](https://getcomposer.org/)

Requires **VERGEd** to already be installed and running on your local server or reachable by your server.  

Get the VERGEd source from: https://github.com/vergecurrency/verge
and follow the instructions for compiling the verged (daemon) or download the appropriate bundle for your platform in the releases tab

## Usage:
Create the composer autoload file with
```composer dump-autoload```

Example Usage (see example.php for additional coverage):

```
// Composer Autoloader ( PSR-4 )
require_once 'vendor/autoload.php';

// Demo RPC configuration
$config = array(
    'user' => 'vergerpcuser',
    'pass' => 'rpcpassword',
    'host' => '127.0.0.1',
    'port' => '20102' );

// Initiate connection
$verge = new Verge\RPC(
    sprintf('http://%s:%s@%s:%s/',
        $config['user'],
        $config['pass'],
        $config['host'],
        $config['port']
    )
);

// Set name of the account.
$account['name'] = 'Positivism';

// Generate a new verge address.
$verge->getnewaddress($account['name']);

```

**PHP-Verge created with <33 by:** [@Positivism](https://github.com/Positivism)