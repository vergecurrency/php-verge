<?php

declare(strict_types=1);

namespace Verge\Rpc\Models;

class WalletInfo
{
    protected $walletName;
    protected $walletversion;
    protected $balance;
    protected $unconfirmed_balance;
    protected $immature_balance;
    protected $txcount;
    protected $keypoololdest;
    protected $keypoolsize;
    protected $keypoolsize_hd_internal;
    protected $paytxfee;
    protected $hdseedid;
    protected $hdmasterkeyid;
}
