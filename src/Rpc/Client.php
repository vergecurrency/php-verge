<?php

declare(strict_types=1);

namespace Verge\Rpc;

use Karriere\JsonDecoder\JsonDecoder;
use Verge\Http\ClientInterface;
use Verge\Rpc\Models\Info;
use Verge\Rpc\Models\StealthAddress;
use Verge\Rpc\Models\WalletInfo;

class Client
{
    /** @var ConfigInterface */
    protected $config;
    /** @var ClientInterface */
    protected $httpClient;
    /** @var DecoderInterface */
    protected $decoder;

    public function __construct(ConfigInterface $config, ClientInterface $httpClient, ?DecoderInterface $decoder = null)
    {
        $this->config = $config;
        $this->httpClient = $httpClient;
        $this->decoder = $decoder ? $decoder : new JsonDecoder(false, true);
    }

    public function getInfo(): Info
    {
        return $this->decoder->decode($this->request('getinfo'), Info::class);
    }

    public function getWalletInfo(): WalletInfo
    {
        return $this->decoder->decode($this->request('getwalletinfo'), WalletInfo::class);
    }

    /**
     * @return StealthAddress[]
     */
    public function getStealthAddresses(): array
    {
        return $this->decoder->decodeMultiple($this->request('liststealthaddresses'), StealthAddress::class);
    }

    protected function request(string $method, array $params = [])
    {
        $options = [
            'headers' => [
                'Content-type: application/json',
            ],
            'body' => json_encode(
                [
                    'method' => $method,
                    'params' => array_values($params),
                    'id' => 1,
                ]
            ),
        ];

        $response = $this->httpClient->request('POST', $this->getUri(), $options);

        $jsonContent = json_decode($response->getBody()->getContents(), true);

        return json_encode($jsonContent['result']);
    }

    protected function getUri(): string
    {
        return sprintf(
            '%s://%s:%s@%s:%s/',
            $this->config->getProtocol(),
            $this->config->getUsername(),
            $this->config->getPassword(),
            $this->config->getHost(),
            $this->config->getPort()
        );
    }
}
