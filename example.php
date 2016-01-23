<?php

## Simple command-line script to show examples

require "./verge.php";

$config = array(
    'user' => 'vergerpcuser',
    'pass' => 'rpcpassword',
    'host' => '127.0.0.1',
    'port' => '20102' );

// create client conncetion
$verge = new verge( $config );


// create a new address
$address = $verge->get_address( 'vergeDEV' );
print( "Address: $address \n" );

// list accounts in wallet
print_r( $verge->list_accounts() );

// get balance in wallet
print( "mkaz: " . $verge->get_balance( 'vergeDEV' ) );

// move money from accounts in wallet
// moves from 'dogecoindark' to account 'vergeDEV'
$verge->move( 'from name', 'to name', 10000 );

// send money externally (withdrawl?)
// send from account to external address
$verge->send( 'name', 'DMheu3hJtEx84DBTKjedKmSwekYvWgsEM3', 10 );


