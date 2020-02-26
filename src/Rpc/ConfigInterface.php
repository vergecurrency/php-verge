<?php

declare(strict_types=1);

namespace Verge\Rpc;

interface ConfigInterface
{
    public function getProtocol(): string;

    public function getHost(): string;

    public function getPort(): int;

    public function getUsername(): string;

    public function getPassword(): string;
}
