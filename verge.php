<?php

/**
 * Project : php-verge library
 * Summary : A basic php library to talk with VERGEd 
 *
 * Source  : forked from https://github.com/doged/php-doged
 *
 * Author  : VERGE
 * License : GPL vv
 */ 

class Verge {

    private $client;

    /** 
     * Create client to conncet on init
     * @param $config array of parameters $host, $port, $user, $pass
     */

    public function __construct($rpc_connection)
    {
        $this->client = $rpc_connection;
    }


    /**
     * Creates or Retrieves a VERGE address for a account name
     * An account is just a string used as key to identify account,
     * A VERGE address is returned which can receive coins
     *
     * @param string $account some string used as key to account
     * @return string VERGE address 
     */
    public function get_address($account)
    {
        return $this->client->getaccountaddress($account);
    }


    /**
     * Given a VERGE address returns the account name
     *
     * @param string $address VERGE addresss
     * @return string account name key
     */
    public function get_account($address) {
        return $this->client->getaccount($address);
    }


    /**
     * Create new address for account, recommended to include
     * account name for further API use.
     *
     * @param string $account account name
     * @return string verge address
     */
    function get_new_address($account='') {
        return $this->client->getnewaddress($account);
    }


    /**
     * Get list of all accounts on in this verged wallet
     *
     * @return array strings of account => balance
     */
    function list_accounts() {
        return $this->client->listaccounts();
    }

    /**
     * Get the details of a transaction
     *
     * @param string $txid transaction id
     * @return array describing the transaction
     */
    function get_transaction($txid) {
        return $this->client->gettransaction( $txid );
    }

    /**
     * Associate verge address to account string
     *
     * @param string $address verge address
     * @param string $account account string
     */
    function set_account($address, $account) {
        return $this->client->setaccount($address, $account);
    }


    /**
     * Get balance for given account
     *
     * @param string $account account name
     * @return float account balance
     */
    function get_balance($account, $minimum_confirmations=1)
    {
        return $this->client->getbalance($account, $minimum_confirmations);
    }


    /**
     * Move coins from one account on wallet to another
     * Both accounts are local to this verged instance
     *
     * @param string $account_from account moving from
     * @param string $account_to account moving to
     * @param float $amount amount of coins to move
     * @return
     */
    function move($account_from, $account_to, $amount)
    {
        return $this->client->move($account_from, $account_to, $amount);
    }


    /**
     * Send coins to any VERGE Address
     *
     * @param string $account account sending coins from
     * @param string $to_address VERGE address sending to
     * @param float $amount amount of coins to send
     * @return string txid
     */
    function send($account, $to_address, $amount)
    {
        $txid = $this->client->sendfrom( $account, $to_address, $amount);  
        return $txid;
    }

    /**
     * Validate a given VERGE Address
     * @param string $address to validate
     * @return array with the properties of the address
     */
    function validate_address($address)
    {
        return $this->client->validateaddress($address);
    }
}