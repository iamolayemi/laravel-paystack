# Advanced Usage Guide

This guide covers advanced features, best practices, and production-ready implementations for the Laravel Paystack package.

## Table of Contents

- [Error Handling](#error-handling)
- [Configuration](#configuration)
- [Best Practices](#best-practices)
- [Testing](#testing)
- [Performance Optimization](#performance-optimization)
- [Security Considerations](#security-considerations)
- [Troubleshooting](#troubleshooting)

## Error Handling

### Custom Exception Classes

The package provides specific exception classes for different types of errors:

```php
use Iamolayemi\Paystack\Exceptions\PaystackApiException;
use Iamolayemi\Paystack\Exceptions\PaystackConnectionException;
use Iamolayemi\Paystack\Exceptions\PaystackValidationException;

try {
    $response = Paystack::transaction()->initialize($data)->response();
} catch (PaystackValidationException $e) {
    // Handle validation errors
    $errors = $e->getErrors();
    Log::error('Paystack validation failed', $errors);
} catch (PaystackApiException $e) {
    // Handle API errors
    Log::error('Paystack API error', [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'endpoint' => $e->getEndpoint(),
        'response' => $e->getResponse(),
    ]);
} catch (PaystackConnectionException $e) {
    // Handle connection errors
    Log::error('Paystack connection failed', [
        'url' => $e->getUrl(),
        'message' => $e->getMessage(),
    ]);
}
```

### Global Exception Handler

Add this to your `app/Exceptions/Handler.php`:

```php
use Iamolayemi\Paystack\Exceptions\PaystackException;

public function register(): void
{
    $this->reportable(function (PaystackException $e) {
        // Log all Paystack exceptions
        Log::error('Paystack Exception', [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'context' => $e->getContext(),
        ]);
    });
}
```

## Configuration

### Environment Variables

```env
# Paystack Configuration
PAYSTACK_SECRET_KEY=sk_live_xxxxxxxxxxxxxxxxxxxxx
PAYSTACK_PUBLIC_KEY=pk_live_xxxxxxxxxxxxxxxxxxxxx
PAYSTACK_CALLBACK_URL=https://yourdomain.com/paystack/callback
PAYSTACK_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxxx

# Development
PAYSTACK_ENVIRONMENT=live  # or 'test'
PAYSTACK_TIMEOUT=30
PAYSTACK_RETRY_ATTEMPTS=3
```

### Service Provider Configuration

```php
// config/paystack.php
return [
    'secret_key' => env('PAYSTACK_SECRET_KEY'),
    'public_key' => env('PAYSTACK_PUBLIC_KEY'),
    'environment' => env('PAYSTACK_ENVIRONMENT', 'test'),
    'timeout' => env('PAYSTACK_TIMEOUT', 30),
    'retry_attempts' => env('PAYSTACK_RETRY_ATTEMPTS', 3),
    'webhook_secret' => env('PAYSTACK_WEBHOOK_SECRET'),
];
```

## Best Practices

### 1. Transaction Management

```php
use Illuminate\Support\Facades\DB;
use Iamolayemi\Paystack\Exceptions\PaystackApiException;

class PaymentService
{
    public function processPayment(array $paymentData): array
    {
        return DB::transaction(function () use ($paymentData) {
            try {
                // Initialize transaction
                $response = Paystack::transaction()
                    ->initialize($paymentData)
                    ->response();

                if (!$response['status']) {
                    throw new PaystackApiException($response['message']);
                }

                // Store transaction in database
                $transaction = Transaction::create([
                    'reference' => $response['data']['reference'],
                    'amount' => $paymentData['amount'],
                    'status' => 'pending',
                    'authorization_url' => $response['data']['authorization_url'],
                ]);

                return [
                    'success' => true,
                    'transaction' => $transaction,
                    'authorization_url' => $response['data']['authorization_url'],
                ];

            } catch (PaystackApiException $e) {
                Log::error('Payment initialization failed', [
                    'error' => $e->getMessage(),
                    'data' => $paymentData,
                ]);

                return [
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }
        });
    }
}
```

### 2. Webhook Handling

```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaystackWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $signature = $request->header('X-Paystack-Signature');
        $payload = $request->getContent();
        $secret = config('paystack.webhook_secret');

        // Verify webhook signature
        if (!$this->verifySignature($payload, $signature, $secret)) {
            Log::warning('Invalid webhook signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        try {
            switch ($event) {
                case 'charge.success':
                    $this->handleSuccessfulCharge($data);
                    break;
                case 'transfer.success':
                    $this->handleSuccessfulTransfer($data);
                    break;
                case 'transfer.failed':
                    $this->handleFailedTransfer($data);
                    break;
                default:
                    Log::info('Unhandled webhook event', ['event' => $event]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'event' => $event,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Processing failed'], 500);
        }
    }

    private function verifySignature(string $payload, string $signature, string $secret): bool
    {
        $expectedSignature = hash_hmac('sha512', $payload, $secret);
        return hash_equals($expectedSignature, $signature);
    }

    private function handleSuccessfulCharge(array $data): void
    {
        $transaction = Transaction::where('reference', $data['reference'])->first();

        if ($transaction) {
            $transaction->update([
                'status' => 'completed',
                'paid_at' => now(),
                'gateway_response' => $data['gateway_response'],
            ]);

            // Trigger success event
            event(new PaymentSuccessful($transaction));
        }
    }
}
```

### 3. Retry Logic

```php
use Illuminate\Support\Facades\Cache;

class PaystackService
{
    public function withRetry(callable $operation, int $maxAttempts = 3): mixed
    {
        $attempt = 1;

        while ($attempt <= $maxAttempts) {
            try {
                return $operation();
            } catch (PaystackConnectionException $e) {
                if ($attempt === $maxAttempts) {
                    throw $e;
                }

                $delay = pow(2, $attempt) * 1000; // Exponential backoff
                usleep($delay * 1000);
                $attempt++;
            }
        }
    }

    public function verifyTransaction(string $reference): array
    {
        return $this->withRetry(function () use ($reference) {
            return Paystack::transaction()
                ->verify($reference)
                ->response();
        });
    }
}
```

## Testing

### Unit Tests

```php
use Tests\TestCase;
use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\Exceptions\PaystackApiException;

class PaymentTest extends TestCase
{
    public function test_successful_payment_initialization()
    {
        $paymentData = [
            'amount' => 500000, // 5000 NGN
            'email' => 'test@example.com',
            'reference' => 'TEST_REF_' . uniqid(),
            'callback_url' => 'https://example.com/callback',
        ];

        $response = Paystack::transaction()
            ->initialize($paymentData)
            ->response();

        $this->assertTrue($response['status']);
        $this->assertArrayHasKey('authorization_url', $response['data']);
        $this->assertEquals($paymentData['reference'], $response['data']['reference']);
    }

    public function test_failed_payment_throws_exception()
    {
        $this->expectException(PaystackApiException::class);

        $invalidData = [
            'amount' => -1000, // Invalid amount
            'email' => 'invalid-email',
        ];

        Paystack::transaction()->initialize($invalidData);
    }
}
```

### Mock Testing

```php
use Illuminate\Support\Facades\Http;

class PaystackMockTest extends TestCase
{
    public function test_mock_paystack_api_response()
    {
        Http::fake([
            'api.paystack.co/transaction/initialize' => Http::response([
                'status' => true,
                'message' => 'Authorization URL created',
                'data' => [
                    'authorization_url' => 'https://checkout.paystack.com/0x234567',
                    'access_code' => '0x234567',
                    'reference' => 'TEST_REF_123',
                ],
            ], 200),
        ]);

        $response = Paystack::transaction()
            ->initialize([
                'amount' => 500000,
                'email' => 'test@example.com',
            ])
            ->response();

        $this->assertTrue($response['status']);
        $this->assertArrayHasKey('authorization_url', $response['data']);
    }
}
```

## Performance Optimization

### 1. Connection Pooling

```php
class PaystackConnectionManager
{
    private static ?Paystack $instance = null;

    public static function getInstance(): Paystack
    {
        if (self::$instance === null) {
            self::$instance = new Paystack(config('paystack.secret_key'));
        }

        return self::$instance;
    }
}
```

### 2. Caching

```php
use Illuminate\Support\Facades\Cache;

class CachedPaystackService
{
    public function getBanks(): array
    {
        return Cache::remember('paystack_banks', 3600, function () {
            return Paystack::bank()->list()->response('data');
        });
    }

    public function getCountries(): array
    {
        return Cache::remember('paystack_countries', 86400, function () {
            return Paystack::country()->list()->response('data');
        });
    }
}
```

## Security Considerations

### 1. Input Validation

```php
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => 'required|integer|min:100|max:1000000000',
            'email' => 'required|email',
            'reference' => 'required|string|max:255|unique:transactions,reference',
            'callback_url' => 'required|url',
            'currency' => ['required', Rule::in(['NGN', 'GHS', 'USD'])],
            'metadata' => 'sometimes|array',
        ];
    }
}
```

### 2. Rate Limiting

```php
// In your routes file
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/paystack/initialize', [PaymentController::class, 'initialize']);
    Route::post('/paystack/verify', [PaymentController::class, 'verify']);
});
```

### 3. Logging and Monitoring

```php
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;

// Log all Paystack interactions
Event::listen('paystack.*', function ($event, $data) {
    Log::info('Paystack event', [
        'event' => $event,
        'data' => $data,
        'timestamp' => now(),
    ]);
});
```

## Troubleshooting

### Common Issues

1. **Invalid Secret Key**
   ```
   Error: Invalid Paystack secret key format. Must start with "sk_"
   ```
   Solution: Ensure your secret key starts with `sk_test_` or `sk_live_`

2. **Connection Timeout**
   ```
   Error: Failed to connect to Paystack API
   ```
   Solution: Check your internet connection and Paystack API status

3. **Webhook Signature Verification Failed**
   ```
   Error: Invalid webhook signature
   ```
   Solution: Verify your webhook secret and signature calculation

### Debug Mode

Enable debug logging in your `.env`:

```env
PAYSTACK_DEBUG=true
LOG_LEVEL=debug
```

### Support

For additional support:
- Check the [Paystack API Documentation](https://paystack.com/docs)
- Review the [package documentation](https://laravel-paystack.netlify.app)
- Create an issue on [GitHub](https://github.com/iamolayemi/laravel-paystack/issues)
