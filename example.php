<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

use Verge\RPC;

/**
 * Example usage of the Verge RPC client.
 *
 * @author 
 */

// RPC connection configuration
$config = [
    'user' => 'vergerpcuser',
    'pass' => 'rpcpassword',
    'host' => '127.0.0.1',
    'port' => '20102',
];

// Build the RPC URL with Basic Authentication
$rpcUrl = sprintf(
    'http://%s:%s@%s:%d/',
    urlencode($config['user']),
    urlencode($config['pass']),
    $config['host'],
    (int)$config['port']
);

// Initialize RPC connection
$verge = new RPC($rpcUrl, debug: true);

try {
    // Set up account information
    $accountName = 'Positivism';

    // Generate a new address for the account
    $newAddress = $verge->getnewaddress($accountName);

    // Fetch all addresses associated with the account
    $addresses = $verge->getaddressesbyaccount($accountName);

    // Get the account's current balance
    $balance = $verge->getbalance($accountName);

    // Display account information
    echo '<h2>Verge Account Information</h2>';
    echo '<strong>Account Name:</strong> ' . htmlspecialchars($accountName) . '<br>';
    echo '<strong>Account Balance:</strong> ' . htmlspecialchars((string)$balance) . ' XVG<br>';
    echo '<strong>New Address:</strong> ' . htmlspecialchars($newAddress) . '<br>';

    echo '<h3>Associated Addresses:</h3>';
    if (!empty($addresses)) {
        echo '<ul>';
        foreach ($addresses as $index => $address) {
            echo '<li>Address #' . htmlspecialchars((string)$index) . ': ' . htmlspecialchars($address) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No addresses found for this account.</p>';
    }

} catch (Exception $e) {
    echo '<p style="color: red;">RPC Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
