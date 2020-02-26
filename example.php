<?php

use Verge\Http\TorClient;
use Verge\Rpc\Client;
use Verge\Rpc\Config;

require __DIR__.'/vendor/autoload.php';

$config = new Config('127.0.0.1', 20102, 'RPCUSER', 'RPCPASS');
$httpClient = new TorClient('127.0.0.1', 9001);
$client = new Client($config, $httpClient);

print_r($client->getInfo());
print_r($client->getWalletInfo());
print_r($client->getStealthAddresses());
