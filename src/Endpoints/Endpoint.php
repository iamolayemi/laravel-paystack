<?php

namespace Iamolayemi\Paystack\Endpoints;

use Exceptions\PaystackConnectionException;
use Iamolayemi\Paystack\Paystack;
use Illuminate\Http\Client\Response;

class Endpoint
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
            throw new PaystackConnectionException('Connection could not be established.');
        }
    }

    /**
     * Return the data from http request.
     * @return array|null The data from the response, or null if no request has been made.
     */
    public function data(): ?array
    {
        return $this->response ? $this->response('data') : null;
    }

    /**
     * Return the response from http request.
     * @param  string  $key  Optional key to extract a specific value from the JSON response.
     * @return array|mixed The full response or a specific value from the response.
     */
    public function response(string $key = ''): ?array
    {
        if (empty($key)) {
            return $this->response?->json();
        }
        return $this->response?->json($key);
    }

    protected function url(string $endpoint): string
    {
        return Endpoint::BASE_URL.ltrim($endpoint, '/');
    }

    /**
     *  * Make a http get request
     * @param  string  $url  The URL to send the request to.
     * @param  array|string|null  $query  Optional query string parameters.
     * @return self This instance for method chaining.
     */
    protected function get(string $url, array|string|null $query = []): self
    {
        $response = $this->paystack->getConnection()->get($url, $query);

        $this->response = $response;

        return $this;
    }

    /**
     * Make a http post request
     * @param  string  $url  The URL to send the request to.
     * @param  array  $payload  The data to be sent.
     * @return self This instance for method chaining.
     */
    protected function post(string $url, array $payload = []): self
    {
        $response = $this->paystack->getConnection()->post($url, $payload);

        $this->response = $response;

        return $this;
    }

    /**
     * Make a http put request
     * @param  string  $url  The URL to send the request to.
     * @param  array  $payload  The data to be sent.
     * @return self This instance for method chaining.
     */
    protected function put(string $url, array $payload = []): self
    {
        $response = $this->paystack->getConnection()->put($url, $payload);

        $this->response = $response;

        return $this;
    }

    /**
     * Make a http delete request
     * @param  string  $url  The URL to send the request to.
     * @param  array  $payload  The data to be sent.
     * @return self This instance for method chaining.
     */
    protected function delete(string $url, array $payload = []): self
    {
        $response = $this->paystack->getConnection()->delete($url, $payload);

        $this->response = $response;

        return $this;
    }
}
