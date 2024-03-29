<?php

namespace Iamolayemi\Paystack\Endpoints;

use Exception;
use Iamolayemi\Paystack\Paystack;
use Illuminate\Http\Client\Response;

class Endpoint
{
    protected const BASE_URL = 'https://api.paystack.co';

    public Paystack $paystack;

    protected ?Response $response = null;

    /**
     * @throws Exception
     */
    public function __construct(Paystack $paystack)
    {
        $this->paystack = $paystack;

        if ($this->paystack->getConnection() === null) {
            throw new Exception('Connection could not be established.');
        }
    }

    /**
     * Return the data from http request.
     */
    public function data(): array
    {
        return $this->response('data');
    }

    /**
     * Return the response from http request.
     *
     * @return array
     */
    public function response(string $key = ''): ?array
    {
        if (! empty($key)) {
            return $this->response->json($key);
        } else {
            return $this->response->json();
        }
    }

    protected function url(string $endpoint): string
    {
        return Endpoint::BASE_URL."$endpoint";
    }

    /**
     *  * Make a http get request
     *
     * @param  array|string|null  $query
     */
    protected function get(string $url, $query = []): self
    {
        $response = $this->paystack->getConnection()->get($url, $query);

        $this->response = $response;

        return $this;
    }

    /**
     * Make a http post request
     */
    protected function post(string $url, array $payload = []): self
    {
        $response = $this->paystack->getConnection()->post($url, $payload);

        $this->response = $response;

        return $this;
    }

    /**
     * Make a http put request
     */
    protected function put(string $url, array $payload = []): self
    {
        $response = $this->paystack->getConnection()->put($url, $payload);

        $this->response = $response;

        return $this;
    }

    /**
     * Make a http put request
     */
    protected function delete(string $url, array $payload = []): self
    {
        $response = $this->paystack->getConnection()->delete($url, $payload);

        $this->response = $response;

        return $this;
    }
}
