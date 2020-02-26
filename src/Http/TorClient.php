<?php

declare(strict_types=1);

namespace Verge\Http;

use GuzzleHttp\Client;

class TorClient extends Client implements ClientInterface
{
    /** @var string */
    protected $host;
    /** @var int */
    protected $port;

    public function __construct(string $host, int $port, array $config = [])
    {
        $this->host = $host;
        $this->port = $port;

        parent::__construct($config);
    }
}
