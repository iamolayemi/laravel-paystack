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
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Paystack
{
    protected string $secretKey;

    private ?PendingRequest $connection = null;

    /**
     * Paystack constructor.
     */
    public function __construct(string $secretKey)
    {
        $this->setSecretKey($secretKey);
        $this->connect();
    }

    private function setSecretKey($secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    private function connect(): void
    {
        $this->connection = Http::withToken($this->secretKey);
    }

    public function getConnection(): ?PendingRequest
    {
        return $this->connection;
    }

    /**
     * Generates a unique reference
     */
    public function generateReference(string $transactionPrefix = null): string
    {
        if ($transactionPrefix) {
            return $transactionPrefix.'_'.uniqid(time());
        }

        return 'PK_'.uniqid(time());
    }

    /**
     * Create a new Balance instance.
     *
     * @throws \Exception
     */
    public function balance(): Balance
    {
        return new Balance($this);
    }

    /**
     * Create a new Bank instance.
     *
     * @throws \Exception
     */
    public function bank(): Bank
    {
        return new Bank($this);
    }

    /**
     * Create a new Country instance.
     *
     * @throws \Exception
     */
    public function country(): Country
    {
        return new Country($this);
    }

    /**
     * Create a new customer instance.
     *
     * @throws \Exception
     */
    public function customer(): Customer
    {
        return new Customer($this);
    }

    /**
     * Create a new dedicated account instance.
     *
     * @throws \Exception
     */
    public function dedicatedAccount(): DedicatedAccount
    {
        return new DedicatedAccount($this);
    }

    /**
     * Create a new invoice instance.
     *
     * @throws \Exception
     */
    public function invoice(): Invoice
    {
        return new Invoice($this);
    }

    /**
     * Create a new page instance.
     *
     * @throws \Exception
     */
    public function page(): Page
    {
        return new Page($this);
    }

    /**
     * Create a new plan instance.
     *
     * @throws \Exception
     */
    public function plan(): Plan
    {
        return new Plan($this);
    }

    /**
     * Create a new Product instance.
     *
     * @throws \Exception
     */
    public function product(): Product
    {
        return new Product($this);
    }

    /**
     * Create a new TransferRecipient instance.
     *
     * @throws \Exception
     */
    public function recipient(): TransferRecipient
    {
        return new TransferRecipient($this);
    }

    /**
     * Create a new Refund instance.
     *
     * @throws \Exception
     */
    public function refund(): Refund
    {
        return new Refund($this);
    }

    /**
     * Create a new Resolve instance.
     *
     * @throws \Exception
     */
    public function resolve(): Resolve
    {
        return new Resolve($this);
    }

    /**
     * Create a new Settlement instance.
     *
     * @throws \Exception
     */
    public function settlement(): Settlement
    {
        return new Settlement($this);
    }

    /**
     * Create a new split transaction instance.
     *
     * @throws \Exception
     */
    public function split(): Split
    {
        return new Split($this);
    }

    /**
     * Create a new SubAccount instance.
     *
     * @throws \Exception
     */
    public function subAccount(): SubAccount
    {
        return new SubAccount($this);
    }

    /**
     * Create a new Subscription instance.
     *
     * @throws \Exception
     */
    public function subscription(): Subscription
    {
        return new Subscription($this);
    }

    /**
     * Create a new transaction instance.
     *
     * @throws \Exception
     */
    public function transaction(): Transaction
    {
        return new Transaction($this);
    }

    /**
     * Create a new Transfer instance.
     *
     * @throws \Exception
     */
    public function transfer(): Transfer
    {
        return new Transfer($this);
    }
}
