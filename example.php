<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Verge\RPC;

/**
 * Example usage of the Verge RPC client.
 *
 * @vergecurrency
 */

// RPC connection configuration
$config = [
    'user' => getenv('VERGE_RPC_USER') ?: 'vergerpcuser',
    'pass' => getenv('VERGE_RPC_PASSWORD') ?: 'rpcpassword',
    'host' => getenv('VERGE_RPC_HOST') ?: '127.0.0.1',
    'port' => (int) (getenv('VERGE_RPC_PORT') ?: 20102),
];

// Build the RPC URL with Basic Authentication
$rpcUrl = sprintf(
    'http://%s:%s@%s:%d/',
    rawurlencode($config['user']),
    rawurlencode($config['pass']),
    $config['host'],
    $config['port']
);

// Initialize RPC connection
$debug = filter_var(getenv('VERGE_RPC_DEBUG') ?: 'false', FILTER_VALIDATE_BOOL);
$verge = new RPC($rpcUrl, debug: $debug);

try {
    $label = 'Positivism';

    // Generate a new address and associate it with a wallet label.
    $newAddress = $verge->getnewaddress($label);

    // Fetch all addresses associated with the label.
    $addresses = array_keys($verge->getaddressesbylabel($label));

    // Fetch the wallet's total available balance.
    $balance = $verge->getbalance();

    echo "Verge Wallet Information\n";
    echo "Label: {$label}\n";
    echo "Balance: {$balance} XVG\n";
    echo "New address: {$newAddress}\n";
    echo "Associated addresses:\n";
    foreach ($addresses as $index => $address) {
        echo sprintf("  #%d: %s\n", $index + 1, $address);
    }
} catch (Throwable $exception) {
    fwrite(STDERR, 'RPC error: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}
