<?php

declare(strict_types=1);

namespace Verge\Rpc;

class Config implements ConfigInterface
{
    /** @var string */
    protected $protocol = 'http';
    /** @var string */
    protected $host;
    /** @var int */
    protected $port;
    /** @var string */
    protected $username;
    /** @var string */
    protected $password;

    public function __construct(string $host, int $port, string $username, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function setProtocol(string $protocol): self
    {
        $this->protocol = $protocol;

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
