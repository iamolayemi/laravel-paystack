# Advanced Usage Guide

This guide covers advanced features, best practices, and production-ready implementations of the Laravel Paystack package.

## Error Handling

### Custom Exception Classes

The package provides several custom exception classes for better error handling:

```php
use Iamolayemi\Paystack\Exceptions\PaystackApiException;
use Iamolayemi\Paystack\Exceptions\PaystackValidationException;
use Iamolayemi\Paystack\Exceptions\PaystackConnectionException;

try {
    $response = Paystack::transaction()
        ->initialize($paymentData)
        ->response();
} catch (PaystackApiException $e) {
    // Handle API-specific errors
    Log::error('Paystack API Error', [
        'message' => $e->getMessage(),
        'api_code' => $e->getApiCode(),
        'api_message' => $e->getApiMessage(),
        'context' => $e->getContext(),
    ]);
} catch (PaystackValidationException $e) {
    // Handle validation errors
    Log::error('Paystack Validation Error', [
        'errors' => $e->getErrors(),
        'payload' => $e->getContext(),
    ]);
} catch (PaystackConnectionException $e) {
    // Handle connection errors
    Log::error('Paystack Connection Error', [
        'message' => $e->getMessage(),
    ]);
}
```

### Response Validation

Always validate API responses before processing:

```php
$response = Paystack::transaction()
    ->initialize($paymentData)
    ->response();

if (!$response || !isset($response['status']) || !$response['status']) {
    throw new Exception('Payment initialization failed');
}

// Check for specific data
if (!isset($response['data']['authorization_url'])) {
    throw new Exception('Authorization URL not received');
}
```

## Environment Management

### Environment Detection

```php
// Check current environment
if (Paystack::isTestMode()) {
    // Use test data
    $amount = 100; // 1 NGN in kobo
} else {
    // Use production data
    $amount = 50000; // 500 NGN in kobo
}
```

### Configuration Management

```php
// config/paystack.php
return [
    'public_key' => env('PAYSTACK_PUBLIC_KEY'),
    'secret_key' => env('PAYSTACK_SECRET_KEY'),
    'webhook_secret' => env('PAYSTACK_WEBHOOK_SECRET'),
    'timeout' => env('PAYSTACK_TIMEOUT', 30),
    'retry_attempts' => env('PAYSTACK_RETRY_ATTEMPTS', 3),
    'retry_delay' => env('PAYSTACK_RETRY_DELAY', 1000),
];
```

## Advanced Payment Patterns

### Recurring Payments

```php
class SubscriptionService
{
    public function createSubscription(array $customerData, string $planCode): array
    {
        // 1. Create or get customer
        $customer = Paystack::customer()
            ->create($customerData)
            ->response('data');

        // 2. Create subscription
        $subscription = Paystack::subscription()
            ->create([
                'customer' => $customer['customer_code'],
                'plan' => $planCode,
                'authorization' => $customerData['authorization_code'],
            ])
            ->response('data');

        return $subscription;
    }

    public function chargeRecurringPayment(string $authorizationCode, int $amount): array
    {
        return Paystack::transaction()
            ->chargeAuthorization([
                'authorization_code' => $authorizationCode,
                'amount' => $amount,
                'email' => 'customer@example.com',
            ])
            ->response('data');
    }
}
```

### Split Payments (Marketplace)

```php
class MarketplaceService
{
    public function processMarketplacePayment(array $paymentData): array
    {
        // 1. Initialize transaction
        $transaction = Paystack::transaction()
            ->initialize($paymentData)
            ->response('data');

        // 2. Create split configuration
        $split = Paystack::split()
            ->create([
                'name' => 'Marketplace Split',
                'type' => 'percentage',
                'currency' => 'NGN',
                'subaccounts' => [
                    [
                        'subaccount' => 'ACCT_merchant1',
                        'share' => 80, // 80% to merchant
                    ],
                    [
                        'subaccount' => 'ACCT_platform',
                        'share' => 20, // 20% to platform
                    ],
                ],
            ])
            ->response('data');

        return [
            'transaction' => $transaction,
            'split' => $split,
        ];
    }
}
```

### Webhook Handling

```php
class PaystackWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Verify webhook signature
        $signature = $request->header('X-Paystack-Signature');
        $payload = $request->getContent();

        if (!$this->verifyWebhookSignature($signature, $payload)) {
            abort(401, 'Invalid signature');
        }

        $event = $request->input('event');
        $data = $request->input('data');

        switch ($event) {
            case 'charge.success':
                $this->handleSuccessfulPayment($data);
                break;
            case 'transfer.success':
                $this->handleSuccessfulTransfer($data);
                break;
            case 'subscription.create':
                $this->handleSubscriptionCreated($data);
                break;
            default:
                Log::info('Unhandled webhook event', ['event' => $event]);
        }

        return response()->json(['status' => 'success']);
    }

    private function verifyWebhookSignature(string $signature, string $payload): bool
    {
        $expectedSignature = hash_hmac('sha512', $payload, config('paystack.secret_key'));
        return hash_equals($expectedSignature, $signature);
    }

    private function handleSuccessfulPayment(array $data): void
    {
        // Update order status
        // Send confirmation email
        // Update inventory
        // etc.
    }
}
```

## Performance Optimization

### Caching Strategies

```php
class PaystackCacheService
{
    public function getBanks(): array
    {
        return Cache::remember('paystack_banks', 3600, function () {
            return Paystack::bank()
                ->list()
                ->response('data');
        });
    }

    public function getCountries(): array
    {
        return Cache::remember('paystack_countries', 86400, function () {
            return Paystack::country()
                ->list()
                ->response('data');
        });
    }
}
```

### Batch Operations

```php
class BatchTransferService
{
    public function processBatchTransfers(array $transfers): array
    {
        $batch = [];

        foreach ($transfers as $transfer) {
            $batch[] = [
                'amount' => $transfer['amount'],
                'recipient' => $transfer['recipient_code'],
                'reference' => $transfer['reference'],
            ];
        }

        return Paystack::transfer()
            ->bulk(['currency' => 'NGN', 'source' => 'balance', 'transfers' => $batch])
            ->response('data');
    }
}
```

## Testing Strategies

### Mocking Paystack API

```php
class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_payment_initialization()
    {
        Http::fake([
            'https://api.paystack.co/transaction/initialize' => Http::response([
                'status' => true,
                'message' => 'Authorization URL created',
                'data' => [
                    'authorization_url' => 'https://checkout.paystack.com/0x123456',
                    'access_code' => '0x123456',
                    'reference' => 'PK_123456789',
                ],
            ], 200),
        ]);

        $response = $this->post('/payments/initialize', [
            'email' => 'test@example.com',
            'amount' => 50000,
        ]);

        $response->assertStatus(302);
        Http::assertSentCount(1);
    }

    public function test_webhook_verification()
    {
        $payload = json_encode(['event' => 'charge.success', 'data' => []]);
        $signature = hash_hmac('sha512', $payload, config('paystack.secret_key'));

        $response = $this->post('/webhooks/paystack', [], [
            'X-Paystack-Signature' => $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);
    }
}
```

## Security Best Practices

### Input Validation

```php
class PaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'amount' => 'required|integer|min:100', // Minimum 1 NGN
            'reference' => 'nullable|string|max:255',
            'callback_url' => 'nullable|url',
            'metadata' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Amount must be at least 1 NGN (100 kobo)',
            'email.email' => 'Please provide a valid email address',
        ];
    }
}
```

### Rate Limiting

```php
// In your routes file
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/payments/initialize', [PaymentController::class, 'initialize']);
    Route::post('/payments/verify', [PaymentController::class, 'verify']);
});
```

## Monitoring and Logging

### Structured Logging

```php
class PaystackLogger
{
    public function logPaymentAttempt(array $data): void
    {
        Log::info('Payment attempt initiated', [
            'email' => $data['email'],
            'amount' => $data['amount'],
            'reference' => $data['reference'],
            'timestamp' => now()->toISOString(),
        ]);
    }

    public function logPaymentSuccess(array $data): void
    {
        Log::info('Payment successful', [
            'reference' => $data['reference'],
            'transaction_id' => $data['id'],
            'amount' => $data['amount'],
            'timestamp' => now()->toISOString(),
        ]);
    }

    public function logPaymentFailure(array $data, string $reason): void
    {
        Log::error('Payment failed', [
            'reference' => $data['reference'],
            'reason' => $reason,
            'timestamp' => now()->toISOString(),
        ]);
    }
}
```

This advanced usage guide provides production-ready patterns and best practices for implementing Paystack payments in your Laravel application.
