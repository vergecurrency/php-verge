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
<img alt="PHP workflow status" src="https://github.com/vergecurrency/php-verge/actions/workflows/php.yml/badge.svg?branch=master">
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

// The examples below cover the public, non-deprecated RPC commands registered
// by Verge Core 26.7. They are commented out so this example remains safe to
// copy and run. Replace placeholder values before enabling a call.

// === Blockchain ===

// Return an overview of the active chain and synchronization state.
// $blockchainInfo = $verge->getblockchaininfo();

// Return statistics about transactions in the recent chain window.
// $chainTxStats = $verge->getchaintxstats(2016);

// Return statistics for a block by hash or height.
// $blockStats = $verge->getblockstats(100);

// Return the hash of the current best block.
// $bestBlockHash = $verge->getbestblockhash();

// Return the height of the current best block.
// $blockCount = $verge->getblockcount();

// Return a decoded block, or raw block hex when verbosity is zero.
// $block = $verge->getblock('blockhash', 1);

// Return the block hash at a specific height.
// $blockHash = $verge->getblockhash(100);

// Return a decoded block header, or raw header hex when verbose is false.
// $blockHeader = $verge->getblockheader('blockhash', true);

// Return information about all known chain tips.
// $chainTips = $verge->getchaintips();

// Return the current proof-of-work difficulty.
// $difficulty = $verge->getdifficulty();

// Return all in-mempool ancestors of a transaction.
// $ancestors = $verge->getmempoolancestors('txid', true);

// Return all in-mempool descendants of a transaction.
// $descendants = $verge->getmempooldescendants('txid', true);

// Return mempool data for one transaction.
// $mempoolEntry = $verge->getmempoolentry('txid');

// Return aggregate mempool state and usage.
// $mempoolInfo = $verge->getmempoolinfo();

// Return transaction IDs, or verbose entries, from the mempool.
// $mempool = $verge->getrawmempool(true);

// Return details for an unspent transaction output.
// $txOut = $verge->gettxout('txid', 0, true);

// Return statistics about the complete UTXO set.
// $txOutSetInfo = $verge->gettxoutsetinfo();

// Prune block files up to a height or timestamp on a pruning node.
// $prunedHeight = $verge->pruneblockchain(100000);

// Persist the current mempool to disk.
// $mempoolSaved = $verge->savemempool();

// Verify the blockchain database.
// $chainIsValid = $verge->verifychain(3, 6);

// Give a block priority over competing blocks of the same height.
// $verge->preciousblock('blockhash');

// Return a proof that one or more transactions are included in a block.
// $txOutProof = $verge->gettxoutproof(['txid'], 'blockhash');

// Verify a transaction inclusion proof and return the proven transaction IDs.
// $provenTxids = $verge->verifytxoutproof('proofhex');

// === Mining ===

// Estimate the network hash rate over a block window.
// $networkHashrate = $verge->getnetworkhashps(120, -1);

// Return hash-rate estimates for every supported Verge mining algorithm.
// $allNetworkHashrates = $verge->getallnetworkhashps(120, -1);

// Return mining-related information.
// $miningInfo = $verge->getmininginfo();

// Adjust the mining priority or fee delta for a transaction.
// $prioritised = $verge->prioritisetransaction('txid', null, 1000);

// Return data needed to construct a block.
// $blockTemplate = $verge->getblocktemplate(['rules' => ['segwit']]);

// Decode a serialized block.
// $decodedBlock = $verge->decodeblock('blockhex');

// Re-serialize a decoded block.
// $serializedBlock = $verge->reserializeblock('blockhex');

// Estimate the fee rate needed for confirmation within a target.
// $feeEstimate = $verge->estimatesmartfee(6, 'CONSERVATIVE');

// Mine blocks immediately to an address.
// $generatedBlocks = $verge->generatetoaddress(1, $address, 1000000);

// Mine blocks immediately to an address from the loaded wallet.
// $generatedBlocks = $verge->generate(1, 1000000);

// Submit a serialized block to the network.
// $submitResult = $verge->submitblock('blockhex');

// === Network ===

// Return the number of connected peers.
// $connectionCount = $verge->getconnectioncount();

// Request ping measurements from all connected peers.
// $verge->ping();

// Return detailed information about connected peers.
// $peerInfo = $verge->getpeerinfo();

// Add, remove, or make a persistent connection to a node.
// $verge->addnode('127.0.0.1:21102', 'onetry');

// Disconnect a peer by address or node ID.
// $verge->disconnectnode('127.0.0.1:21102');

// Return information about manually added nodes.
// $addedNodes = $verge->getaddednodeinfo(true);

// Return total network traffic counters.
// $networkTotals = $verge->getnettotals();

// Return network configuration and connection state.
// $networkInfo = $verge->getnetworkinfo();

// Add or remove an IP address or subnet from the ban list.
// $verge->setban('192.0.2.0/24', 'add', 86400, false);

// Return all banned IP addresses and subnets.
// $bannedPeers = $verge->listbanned();

// Clear every entry from the ban list.
// $verge->clearbanned();

// Enable or disable all P2P network activity.
// $networkActive = $verge->setnetworkactive(true);

// Return known node addresses from the address manager.
// $nodeAddresses = $verge->getnodeaddresses(10);

// === Raw transactions ===

// Return a raw or decoded transaction.
// $transaction = $verge->getrawtransaction('txid', true, 'blockhash');

// Create an unsigned raw transaction.
// $rawTransaction = $verge->createrawtransaction(
//     [['txid' => 'input-txid', 'vout' => 0]],
//     [$address => 1.0]
// );

// Decode a serialized transaction.
// $decodedTransaction = $verge->decoderawtransaction('transactionhex', true);

// Decode a serialized script.
// $decodedScript = $verge->decodescript('scripthex');

// Broadcast a signed raw transaction.
// $broadcastTxid = $verge->sendrawtransaction('signedtransactionhex', false);

// Combine partially signed versions of the same transaction.
// $combinedTransaction = $verge->combinerawtransaction(['transactionhex1', 'transactionhex2']);

// Sign a raw transaction with supplied private keys.
// $signedTransaction = $verge->signrawtransactionwithkey(
//     'transactionhex',
//     ['privatekey'],
//     []
// );

// Test whether raw transactions would be accepted by the mempool.
// $acceptance = $verge->testmempoolaccept(['signedtransactionhex'], 0.10);

// Add wallet inputs and change to an unsigned raw transaction.
// $fundedTransaction = $verge->fundrawtransaction('transactionhex');

// Sign a raw transaction with keys from the loaded wallet.
// $signedTransaction = $verge->signrawtransactionwithwallet('transactionhex');

// === Wallet ===

// Mark an unconfirmed wallet transaction and its descendants as abandoned.
// $verge->abandontransaction('txid');

// Stop an active wallet rescan.
// $rescanAborted = $verge->abortrescan();

// Add a multisignature address to the wallet.
// $multisig = $verge->addmultisigaddress(2, ['publickey1', 'publickey2'], $label);

// Back up the loaded wallet.
// $verge->backupwallet('/absolute/path/to/wallet-backup.dat');

// Increase the fee of an unconfirmed replaceable transaction.
// $bumpedFee = $verge->bumpfee('txid');

// Create and load a new wallet.
// $createdWallet = $verge->createwallet('wallet-name');

// Return the private key for a wallet address.
// $privateKey = $verge->dumpprivkey($address);

// Export all wallet keys in a human-readable format.
// $verge->dumpwallet('/absolute/path/to/wallet-dump.txt');

// Encrypt the wallet with a passphrase.
// $verge->encryptwallet('strong-passphrase');

// Export a stealth address and its secrets.
// $stealthAddress = $verge->exportstealthaddress('stealth-label');

// Return wallet-specific information about an address.
// $addressInfo = $verge->getaddressinfo($address);

// Return the wallet's available balance.
// $balance = $verge->getbalance();

// Create a new stealth address.
// $stealthAddress = $verge->getnewstealthaddress('stealth-label');

// Return a new internal address for transaction change.
// $changeAddress = $verge->getrawchangeaddress();

// Return the amount received by an address.
// $received = $verge->getreceivedbyaddress($address, 1);

// Return detailed information about a wallet transaction.
// $walletTransaction = $verge->gettransaction('txid', true);

// Return the wallet's unconfirmed balance.
// $unconfirmedBalance = $verge->getunconfirmedbalance();

// Return state and metadata for the loaded wallet.
// $walletInfo = $verge->getwalletinfo();

// Import multiple addresses, scripts, or keys in one request.
// $imported = $verge->importmulti(
//     [['scriptPubKey' => ['address' => $address], 'timestamp' => 'now']],
//     ['rescan' => false]
// );

// Import a private key into the wallet.
// $verge->importprivkey('privatekey', $label, true);

// Import keys from a wallet dump file.
// $verge->importwallet('/absolute/path/to/wallet-dump.txt');

// Import an address or script as watch-only.
// $verge->importaddress($address, $label, true, false);

// Import funds proven by a raw transaction and transaction-output proof.
// $verge->importprunedfunds('transactionhex', 'proofhex');

// Import a public key as watch-only.
// $verge->importpubkey('publickeyhex', $label, true);

// Import a stealth address from its scan and spend secrets.
// $verge->importstealthaddress('scan-secret', 'spend-secret', 'stealth-label');

// Refill the wallet keypool.
// $verge->keypoolrefill(100);

// Return wallet addresses grouped by common ownership.
// $addressGroupings = $verge->listaddressgroupings();

// Return transaction outputs currently locked from coin selection.
// $lockedOutputs = $verge->listlockunspent();

// Return balances received by wallet addresses.
// $receivedByAddress = $verge->listreceivedbyaddress(1, false, false);

// Return wallet transactions since a block.
// $transactionsSinceBlock = $verge->listsinceblock('blockhash', 1, false, true);

// Return stealth addresses held by the wallet.
// $stealthAddresses = $verge->liststealthaddresses(false);

// Return recent wallet transactions.
// $transactions = $verge->listtransactions('*', 10, 0, false);

// Return unspent wallet transaction outputs.
// $unspent = $verge->listunspent(1, 9999999, [$address]);

// Return the names of currently loaded wallets.
// $wallets = $verge->listwallets();

// Load an existing wallet file.
// $loadedWallet = $verge->loadwallet('wallet.dat');

// Lock or unlock transaction outputs for coin selection.
// $locked = $verge->lockunspent(false, [['txid' => 'txid', 'vout' => 0]]);

// Send different amounts to multiple addresses.
// $txid = $verge->sendmany('', [$address => 1.0], 1, 'batch payment');

// Send XVG to an address.
// $txid = $verge->sendtoaddress($address, 1.0, 'payment', 'recipient');

// Send XVG to a stealth address.
// $txid = $verge->sendtostealthaddress('stealth-address', 1.0, 'narration');

// Set the wallet transaction fee rate in XVG per kilobyte.
// $feeSet = $verge->settxfee(0.001);

// Sign a message with the private key for a wallet address.
// $signature = $verge->signmessage($address, 'message');

// Remove the wallet encryption key from memory.
// $verge->walletlock();

// Change the wallet encryption passphrase.
// $verge->walletpassphrasechange('old-passphrase', 'new-passphrase');

// Unlock the wallet for a limited number of seconds.
// $verge->walletpassphrase('strong-passphrase', 60);

// Remove a previously imported pruned-funds transaction.
// $verge->removeprunedfunds('txid');

// Rescan the blockchain for wallet transactions.
// $rescan = $verge->rescanblockchain(0);

// Set or generate a new HD wallet seed.
// $verge->sethdseed(true, 'privatekey');

// Return all addresses assigned to a wallet label.
// $addresses = $verge->getaddressesbylabel($label);

// Return the amount received by a wallet label.
// $received = $verge->getreceivedbylabel($label, 1);

// Return wallet labels, optionally filtered by purpose.
// $labels = $verge->listlabels('receive');

// Return balances received by wallet labels.
// $receivedByLabel = $verge->listreceivedbylabel(1, false, false);

// Assign a label to an address.
// $verge->setlabel($address, $label);

// === Utility and control ===

// Return memory allocator statistics.
// $memoryInfo = $verge->getmemoryinfo('stats');

// Include or exclude runtime logging categories.
// $logging = $verge->logging(['net'], ['mempool']);

// Validate an address and return basic details.
// $validation = $verge->validateaddress($address);

// Create a multisignature address without adding it to the wallet.
// $multisig = $verge->createmultisig(2, ['publickey1', 'publickey2']);

// Verify a signed message.
// $signatureIsValid = $verge->verifymessage($address, 'signature', 'message');

// Sign a message with a supplied private key.
// $signature = $verge->signmessagewithprivkey('privatekey', 'message');

// Select the mining algorithm used by the node.
// $algorithm = $verge->setalgo('scrypt');

// Return node diagnostic information.
// $debugInfo = $verge->debuginfo();

// Return help for all RPC commands or one named command.
// $help = $verge->help('getblockchaininfo');

// Return the number of seconds the server has been running.
// $uptime = $verge->uptime();

// Shut down Verge Core.
// $verge->stop();

// === Secure messaging (SMSG) ===

// Enable secure messaging, optionally for a named wallet.
// $smsgEnabled = $verge->smsgenable('wallet.dat');

// Disable secure messaging.
// $smsgDisabled = $verge->smsgdisable();

// List or change secure-messaging options.
// $smsgOptions = $verge->smsgoptions('list', true);

// List or manage local secure-messaging keys.
// $localKeys = $verge->smsglocalkeys('all');

// Scan the blockchain for public keys used by secure messaging.
// $chainScan = $verge->smsgscanchain();

// Scan secure-message buckets for messages addressed to local keys.
// $bucketScan = $verge->smsgscanbuckets();

// Return secure-messaging status and statistics.
// $smsgInfo = $verge->smsginfo();

// Flush the secure-message database to disk.
// $smsgFlushed = $verge->flushsmgsdb();

// Add an address and public key to the secure-message key database.
// $smsgAddress = $verge->smsgaddaddress($address, 'publickey');

// Enable secure-message reception for a wallet address.
// $localAddress = $verge->smsgaddlocaladdress($address);

// Import a private key into the secure-message database.
// $smsgKey = $verge->smsgimportprivkey('privatekey', $label);

// Return the compressed public key used to message an address.
// $smsgPublicKey = $verge->smsggetpubkey($address);

// Send a paid encrypted message.
// $sentMessage = $verge->smsgsend($address, 'recipient-address-or-chatkey', 'message', true, 31);

// List, filter, or clear received secure messages.
// $inbox = $verge->smsginbox('all');

// List, filter, or clear sent secure messages.
// $outbox = $verge->smsgoutbox('all');

// Return secure-message bucket statistics or a bucket dump.
// $buckets = $verge->smsgbuckets('stats');

// View messages by address, label, sort order, or date.
// $messages = $verge->smsgview('*', 'desc');

// Return one secure message by its 56-character message ID.
// $message = $verge->smsg('56-character-message-id');

// Purge one secure message by its 56-character message ID.
// $purged = $verge->smsgpurge('56-character-message-id');

```

The included `example.php` reads `VERGE_RPC_USER`, `VERGE_RPC_PASSWORD`,
`VERGE_RPC_HOST`, `VERGE_RPC_PORT`, and optional `VERGE_RPC_DEBUG` environment
variables. See the GitHub Actions workflow for a complete Verge Core 26.7
regtest setup.

**PHP-Verge created with <33 by:** [@Positivism](https://github.com/Positivism)
