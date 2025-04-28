<?php
declare(strict_types=1);

namespace Verge;

use Exception;
use RuntimeException;
use InvalidArgumentException;

/**
 * A JSON-RPC 2.0 Client
 *
 * @author 
 */
class RPC
{
    /**
     * The server URL
     *
     * @var string
     */
    private string $url;

    /**
     * If true, requests are sent as notifications (no response expected)
     *
     * @var bool
     */
    private bool $notification = false;

    /**
     * Message ID counter
     *
     * @var int
     */
    private int $id = 1;

    /**
     * Enable or disable debug output
     *
     * @var bool
     */
    private bool $debug;

    /**
     * RPC constructor.
     *
     * @param string $url
     * @param bool $debug
     */
    public function __construct(string $url, bool $debug = false)
    {
        $this->url = $url;
        $this->debug = $debug;
    }

    /**
     * Enable or disable notification mode.
     *
     * @param bool $notification
     * @return void
     */
    public function setRPCNotification(bool $notification): void
    {
        $this->notification = $notification;
    }

    /**
     * Makes a JSON-RPC request
     *
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function __call(string $method, array $params): mixed
    {
        if (!is_scalar($method)) {
            throw new InvalidArgumentException('Method name must be a scalar.');
        }

        $currentId = $this->notification ? null : $this->id++;

        $payload = [
            'jsonrpc' => '2.0',
            'method'  => $method,
            'params'  => array_values($params),
            'id'      => $currentId,
        ];

        $requestData = json_encode($payload);

        if ($this->debug) {
            echo "***** Request *****\n" . $requestData . "\n***** End Of Request *****\n\n";
        }

        $response = $this->sendRequest($requestData);

        if ($this->notification) {
            // No response expected
            return true;
        }

        if (!isset($response['id']) || $response['id'] !== $currentId) {
            throw new RuntimeException('Incorrect response ID (request ID: ' . $currentId . ', response ID: ' . ($response['id'] ?? 'null') . ')');
        }

        if (isset($response['error']) && $response['error'] !== null) {
            $errorMessage = is_array($response['error']) ? json_encode($response['error']) : $response['error'];
            throw new RuntimeException('RPC Error: ' . $errorMessage);
        }

        return $response['result'] ?? null;
    }

    /**
     * Internal method to send a request using cURL.
     *
     * @param string $data
     * @return array
     * @throws Exception
     */
    private function sendRequest(string $data): array
    {
        $ch = curl_init($this->url);

        if ($ch === false) {
            throw new RuntimeException('Failed to initialize cURL');
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST            => true,
            CURLOPT_HTTPHEADER      => [
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS      => $data,
            CURLOPT_TIMEOUT         => 10,
        ]);

        $rawResponse = curl_exec($ch);

        if ($rawResponse === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException('cURL error: ' . $error);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($this->debug) {
            echo "***** Server Response *****\n" . $rawResponse . "\n***** End Of Server Response *****\n\n";
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new RuntimeException('Unexpected HTTP status code: ' . $httpCode);
        }

        $response = json_decode($rawResponse, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $response;
    }
}
