<?php

namespace Iamolayemi\Paystack\Endpoints;

use Iamolayemi\Paystack\Exceptions\PaystackApiException;
use Iamolayemi\Paystack\Exceptions\PaystackConnectionException;
use Iamolayemi\Paystack\Exceptions\PaystackValidationException;
use Iamolayemi\Paystack\Paystack;
use Illuminate\Http\Client\Response;

abstract class Endpoint
{
    protected const BASE_URL = 'https://api.paystack.co/';

    public Paystack $paystack;

    protected ?Response $response = null;

    /**
     * @throws PaystackConnectionException
     */
    public function __construct(Paystack $paystack)
    {
        $this->paystack = $paystack;

        if ($this->paystack->getConnection() === null) {
            throw PaystackConnectionException::connectionFailed(self::BASE_URL);
        }
    }

    /**
     * Return the data from http request.
     *
     * @return array<string, mixed>|null The data from the response, or null if no request has been made.
     */
    public function data(): ?array
    {
        return $this->response ? $this->response('data') : null;
    }

    /**
     * Return the response from http request.
     *
     * @param  string  $key  Optional key to extract a specific value from the JSON response.
     * @return array<string, mixed>|mixed The full response or a specific value from the response.
     */
    public function response(string $key = ''): mixed
    {
        if (empty($key)) {
            return $this->response?->json();
        }

        return $this->response?->json($key);
    }

    /**
     * Check if the response was successful.
     */
    public function isSuccessful(): bool
    {
        return $this->response?->successful() ?? false;
    }

    /**
     * Get the HTTP status code of the response.
     */
    public function getStatusCode(): ?int
    {
        return $this->response?->status();
    }

    protected function url(string $endpoint): string
    {
        return self::BASE_URL.ltrim($endpoint, '/');
    }

    /**
     * Make a http get request
     *
     * @param  string  $url  The URL to send the request to.
     * @param  array<string, mixed>|string|null  $query  Optional query string parameters.
     * @return self This instance for method chaining.
     *
     * @throws PaystackApiException
     */
    protected function get(string $url, array|string|null $query = []): self
    {
        try {
            $connection = $this->paystack->getConnection();
            if ($connection === null) {
                throw PaystackConnectionException::connectionFailed($url);
            }

            $response = $connection->get($url, $query);
            $this->response = $response;

            if (! $response->successful()) {
                $this->handleErrorResponse($response, $url);
            }

            return $this;
        } catch (\Exception $e) {
            throw PaystackConnectionException::connectionFailed($url, $e);
        }
    }

    /**
     * Make a http post request
     *
     * @param  string  $url  The URL to send the request to.
     * @param  array<string, mixed>  $payload  The data to be sent.
     * @return self This instance for method chaining.
     *
     * @throws PaystackApiException
     */
    protected function post(string $url, array $payload = []): self
    {
        try {
            $connection = $this->paystack->getConnection();
            if ($connection === null) {
                throw PaystackConnectionException::connectionFailed($url);
            }

            $response = $connection->post($url, $payload);
            $this->response = $response;

            if (! $response->successful()) {
                $this->handleErrorResponse($response, $url);
            }

            return $this;
        } catch (\Exception $e) {
            throw PaystackConnectionException::connectionFailed($url, $e);
        }
    }

    /**
     * Make a http put request
     *
     * @param  string  $url  The URL to send the request to.
     * @param  array<string, mixed>  $payload  The data to be sent.
     * @return self This instance for method chaining.
     *
     * @throws PaystackApiException
     */
    protected function put(string $url, array $payload = []): self
    {
        try {
            $connection = $this->paystack->getConnection();
            if ($connection === null) {
                throw PaystackConnectionException::connectionFailed($url);
            }

            $response = $connection->put($url, $payload);
            $this->response = $response;

            if (! $response->successful()) {
                $this->handleErrorResponse($response, $url);
            }

            return $this;
        } catch (\Exception $e) {
            throw PaystackConnectionException::connectionFailed($url, $e);
        }
    }

    /**
     * Make a http delete request
     *
     * @param  string  $url  The URL to send the request to.
     * @param  array<string, mixed>  $payload  The data to be sent.
     * @return self This instance for method chaining.
     *
     * @throws PaystackApiException
     */
    protected function delete(string $url, array $payload = []): self
    {
        try {
            $connection = $this->paystack->getConnection();
            if ($connection === null) {
                throw PaystackConnectionException::connectionFailed($url);
            }

            $response = $connection->delete($url, $payload);
            $this->response = $response;

            if (! $response->successful()) {
                $this->handleErrorResponse($response, $url);
            }

            return $this;
        } catch (\Exception $e) {
            throw PaystackConnectionException::connectionFailed($url, $e);
        }
    }

    /**
     * Handle error responses from the API.
     *
     * @throws PaystackApiException
     */
    protected function handleErrorResponse(Response $response, string $url): void
    {
        $responseData = $response->json();

        if (is_array($responseData)) {
            throw PaystackApiException::fromResponse($responseData, $url);
        }

        throw new PaystackApiException(
            'Unknown API error occurred',
            $response->status(),
            $url
        );
    }

    /**
     * Validate required parameters.
     *
     * @param  array<string, mixed>  $data
     * @param  array<int, string>  $required
     *
     * @throws PaystackValidationException
     */
    protected function validateRequired(array $data, array $required): void
    {
        $errors = [];

        foreach ($required as $field) {
            if (! isset($data[$field]) || empty($data[$field])) {
                $errors[$field] = "The {$field} field is required.";
            }
        }

        if (! empty($errors)) {
            throw new PaystackValidationException('Validation failed', $errors);
        }
    }
}
