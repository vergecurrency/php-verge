<?php

declare(strict_types=1);

namespace Verge;

use JsonException;
use RuntimeException;

/**
 * Small JSON-RPC client for Verge Core.
 */
final class RPC
{
    private bool $notification = false;
    private int $id = 1;

    public function __construct(
        private readonly string $url,
        private readonly bool $debug = false,
        private readonly int $timeout = 10,
    ) {
        if ($url === '') {
            throw new \InvalidArgumentException('The RPC URL cannot be empty.');
        }

        if ($timeout < 1) {
            throw new \InvalidArgumentException('The timeout must be at least one second.');
        }
    }

    public function setRPCNotification(bool $notification): void
    {
        $this->notification = $notification;
    }

    /**
     * @param array<int, mixed> $params
     * @return mixed
     */
    public function __call(string $method, array $params): mixed
    {
        if ($method === '') {
            throw new \InvalidArgumentException('The RPC method cannot be empty.');
        }

        $currentId = $this->notification ? null : $this->id++;
        $payload = [
            'jsonrpc' => '1.0',
            'method' => $method,
            'params' => array_values($params),
            'id' => $currentId,
        ];

        try {
            $requestData = json_encode($payload, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Unable to encode the RPC request.', 0, $exception);
        }

        if ($this->debug) {
            fwrite(STDERR, "***** Request *****\n{$requestData}\n***** End Of Request *****\n\n");
        }

        $response = $this->sendRequest($requestData);

        if ($this->notification) {
            return true;
        }

        if (!array_key_exists('id', $response) || $response['id'] !== $currentId) {
            $responseId = $response['id'] ?? 'null';
            throw new RuntimeException(
                "Incorrect response ID (request ID: {$currentId}, response ID: {$responseId})"
            );
        }

        if (($response['error'] ?? null) !== null) {
            try {
                $error = json_encode($response['error'], JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                $error = 'Unknown RPC error';
            }

            throw new RuntimeException('RPC error: ' . $error);
        }

        return $response['result'] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    private function sendRequest(string $data): array
    {
        $handle = curl_init($this->url);

        if ($handle === false) {
            throw new RuntimeException('Failed to initialize cURL.');
        }

        try {
            curl_setopt_array($handle, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_CONNECTTIMEOUT => min(5, $this->timeout),
                CURLOPT_TIMEOUT => $this->timeout,
            ]);

            $rawResponse = curl_exec($handle);
            if ($rawResponse === false) {
                throw new RuntimeException('cURL error: ' . curl_error($handle));
            }

            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        } finally {
            curl_close($handle);
        }

        if ($this->debug) {
            fwrite(STDERR, "***** Server Response *****\n{$rawResponse}\n***** End Of Server Response *****\n\n");
        }

        if ($rawResponse === '' && $this->notification) {
            return [];
        }

        try {
            $response = json_decode($rawResponse, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException(
                "Invalid JSON response (HTTP {$httpCode}): {$exception->getMessage()}",
                0,
                $exception
            );
        }

        if (!is_array($response)) {
            throw new RuntimeException("Invalid RPC response type (HTTP {$httpCode}).");
        }

        // Verge Core returns HTTP 500 for valid JSON-RPC error responses. Let
        // __call() surface those details instead of replacing them with a status.
        if (($httpCode < 200 || $httpCode >= 300) && !array_key_exists('error', $response)) {
            throw new RuntimeException("Unexpected HTTP status code: {$httpCode}");
        }

        return $response;
    }
}
