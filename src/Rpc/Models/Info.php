<?php

declare(strict_types=1);

namespace Verge\Rpc\Models;

class Info
{
    protected $deprecationWarning;
    protected $version;
    protected $protocolversion;
    protected $walletversion;
    protected $balance;
    protected $blocks;
    protected $headers;
    protected $timeoffset;
    protected $connections;
    protected $proxy;
    protected $powAlgoId;
    protected $powAlgo;
    protected $difficulty;
    protected $difficultyX17;
    protected $difficultyScrypt;
    protected $difficultyGroestl;
    protected $difficultyLyra2re;
    protected $difficultyBlake;
    protected $testnet;
    protected $netName;
    protected $keypoololdest;
    protected $keypoolsize;
    protected $paytxfee;
    protected $relayfee;
    protected $errors;
}
