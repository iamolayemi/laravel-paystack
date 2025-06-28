<?php

namespace Iamolayemi\Paystack;

use Iamolayemi\Paystack\Endpoints\Balance;
use Iamolayemi\Paystack\Endpoints\Bank;
use Iamolayemi\Paystack\Endpoints\Country;
use Iamolayemi\Paystack\Endpoints\Customer;
use Iamolayemi\Paystack\Endpoints\DedicatedAccount;
use Iamolayemi\Paystack\Endpoints\Invoice;
use Iamolayemi\Paystack\Endpoints\Page;
use Iamolayemi\Paystack\Endpoints\Plan;
use Iamolayemi\Paystack\Endpoints\Product;
use Iamolayemi\Paystack\Endpoints\Refund;
use Iamolayemi\Paystack\Endpoints\Resolve;
use Iamolayemi\Paystack\Endpoints\Settlement;
use Iamolayemi\Paystack\Endpoints\Split;
use Iamolayemi\Paystack\Endpoints\SubAccount;
use Iamolayemi\Paystack\Endpoints\Subscription;
use Iamolayemi\Paystack\Endpoints\Transaction;
use Iamolayemi\Paystack\Endpoints\Transfer;
use Iamolayemi\Paystack\Endpoints\TransferRecipient;
use Iamolayemi\Paystack\Exceptions\PaystackConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Paystack
{
    protected string $secretKey;

    private ?PendingRequest $connection = null;

    /**
     * Paystack constructor.
     * @throws PaystackConnectionException
     */
    public function __construct(string $secretKey)
    {
        $this->setSecretKey($secretKey);
        $this->connect();
    }

    private function setSecretKey(string $secretKey): void
    {
        if (empty($secretKey)) {
            throw new PaystackConnectionException('Secret key cannot be empty.');
        }

        if (!Str::startsWith($secretKey, ['sk_test_', 'sk_live_'])) {
            throw new PaystackConnectionException('Invalid secret key format. Must start with sk_test_ or sk_live_.');
        }

        $this->secretKey = $secretKey;
    }

    private function connect(): void
    {
        $this->connection = Http::withToken($this->secretKey)
            ->withHeaders([
                'User-Agent' => 'Laravel-Paystack/2.0',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->timeout(30)
            ->retry(3, 1000);
    }

    public function getConnection(): ?PendingRequest
    {
        return $this->connection;
    }

    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * Check if using test environment
     */
    public function isTestMode(): bool
    {
        return Str::startsWith($this->secretKey, 'sk_test_');
    }

    /**
     * Check if using live environment
     */
    public function isLiveMode(): bool
    {
        return Str::startsWith($this->secretKey, 'sk_live_');
    }

    /**
     * Generates a unique reference
     */
    public function generateReference(?string $transactionPrefix = null): string
    {
        $prefix = $transactionPrefix ?: 'PK';
        $timestamp = time();
        $uniqueId = uniqid();

        return sprintf('%s_%s_%s', $prefix, $timestamp, $uniqueId);
    }

    /**
     * Create a new Balance instance.
     */
    public function balance(): Balance
    {
        return new Balance($this);
    }

    /**
     * Create a new Bank instance.
     */
    public function bank(): Bank
    {
        return new Bank($this);
    }

    /**
     * Create a new Country instance.
     */
    public function country(): Country
    {
        return new Country($this);
    }

    /**
     * Create a new customer instance.
     */
    public function customer(): Customer
    {
        return new Customer($this);
    }

    /**
     * Create a new dedicated account instance.
     */
    public function dedicatedAccount(): DedicatedAccount
    {
        return new DedicatedAccount($this);
    }

    /**
     * Create a new invoice instance.
     */
    public function invoice(): Invoice
    {
        return new Invoice($this);
    }

    /**
     * Create a new page instance.
     */
    public function page(): Page
    {
        return new Page($this);
    }

    /**
     * Create a new plan instance.
     */
    public function plan(): Plan
    {
        return new Plan($this);
    }

    /**
     * Create a new Product instance.
     */
    public function product(): Product
    {
        return new Product($this);
    }

    /**
     * Create a new TransferRecipient instance.
     */
    public function recipient(): TransferRecipient
    {
        return new TransferRecipient($this);
    }

    /**
     * Create a new Refund instance.
     */
    public function refund(): Refund
    {
        return new Refund($this);
    }

    /**
     * Create a new Resolve instance.
     */
    public function resolve(): Resolve
    {
        return new Resolve($this);
    }

    /**
     * Create a new Settlement instance.
     */
    public function settlement(): Settlement
    {
        return new Settlement($this);
    }

    /**
     * Create a new split transaction instance.
     */
    public function split(): Split
    {
        return new Split($this);
    }

    /**
     * Create a new sub account instance.
     */
    public function subAccount(): SubAccount
    {
        return new SubAccount($this);
    }

    /**
     * Create a new subscription instance.
     */
    public function subscription(): Subscription
    {
        return new Subscription($this);
    }

    /**
     * Create a new transaction instance.
     */
    public function transaction(): Transaction
    {
        return new Transaction($this);
    }

    /**
     * Create a new transfer instance.
     */
    public function transfer(): Transfer
    {
        return new Transfer($this);
    }
}
