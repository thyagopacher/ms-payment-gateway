![PHP](https://img.shields.io/badge/PHP-8.4-blue)
![Laravel](https://img.shields.io/badge/Laravel-13-red)
![CI](https://github.com/thyagopacher/ms-payment-gateway/actions/workflows/ci.yml/badge.svg)

# Payment Gateway Microservice (Laravel)

A scalable **payment gateway microservice** built with Laravel, designed to integrate with multiple Brazilian banks and support different payment methods.

## Supported Payment Methods

- **Pix**
- **Boleto (Bank Slip)**

## Supported Banks

- Banco do Brasil
- Itaú
- Bradesco
- Santander

## Architecture Goals

This project was designed focusing on modern backend architecture principles:

- Clean Architecture
- Event-Driven Design
- Asynchronous Processing
- Resilience and Scalability
- Multi-bank integration abstraction

## Main Technologies

- PHP 8.4
- Laravel
- Kafka (event streaming)
- Redis (queues and cache)
- Horizon (queue monitoring)
- Docker
- Kubernetes
- PHPUnit (testing)

## Observability

Application monitoring and error tracking:

- New Relic
- Sentry

## CI / CD

Continuous Integration is implemented using **GitHub Actions**.

The pipeline performs the following steps:

1. Installs project dependencies
2. Prepares the testing environment
3. Starts Kafka and Redis services
4. Runs automated tests using PHPUnit

Workflow files are located in:


.github/workflows


## Running the Project

### Using Docker

Start the containers:

```shell
docker-compose up -d
```

Install dependencies:


composer install


Run database migrations:

```shell
php artisan migrate
```

## Running Tests


php artisan test


Tests include:

- Feature tests
- Integration tests
- Payment workflow validations

## Event Processing

Payments are processed asynchronously using **Kafka** consumers.

Example consumer command:

```shell
php artisan kafka:consume-payments
```

## Project Structure

The project follows a **layered and factory-based architecture** with clear separation of concerns:

```
Controllers → Services → Factories → Clients (Bank APIs)
    ↓            ↓
Requests    Repositories → Models → Database
    ↓
Resources   Events/Jobs → Kafka/Queue
```

### Architecture & Design Patterns

- **Layered Architecture**: Clear separation between HTTP, business logic, and data layers
- **Factory Pattern**: `PaymentMethodFactory` dynamically instantiates payment services
- **Strategy Pattern**: `PaymentMethodInterface` enables different implementations per payment method
- **Repository Pattern**: Data access abstraction via repositories
- **DTOs**: Type-safe data transfer objects (`PaymentoDTO`, `CreateChargeDTO`)
- **Event-Driven**: Asynchronous processing with `PaymentApproved` events

### Core Layers

#### **Controllers**
- `PaymentController` - Generic CRUD and reporting endpoints
- `PixController` - Pix-specific operations
- `BankSlipController` - Bank slip operations
- `StripeController` - *(recommended to implement following this pattern)*

#### **Services**
- `PaymentService` - Orchestration and payment creation
- `PixService` - Pix payment implementation
- `BankSlipService` - Bank slip implementation
- `CreditCardService` - Credit card logic (ready for webhooks)

#### **Factories & Clients**
- `PaymentMethodFactory` - Creates appropriate service based on payment method
- `BankFactory` - Creates bank-specific clients
- `StripeApiClient` - Stripe API integration
- `BaseAuthApiClient` - Base authentication for bank APIs

#### **Data Layer**
- `Repositories` - Abstract data access (Person, Payment, etc.)
- `Models` - Eloquent models (Payment, Pix, BankSlip, Bank)
- `DTOs` - Typed data transfer objects
- `Enums` - Type-safe enumerations (PaymentStatus, PaymentMethod)

### Supported Payment Methods

Each payment method has isolated implementation:

| Method | Service | Controller | Clients | Status |
|--------|---------|-----------|---------|--------|
| **Pix** | `PixService` | `PixController` | Multiple banks | ✅ Active |
| **Bank Slip** | `BankSlipService` | `BankSlipController` | BB, Itaú, Bradesco, Santander | ✅ Active |
| **Credit Card** | `CreditCardService` | *(create StripeController)* | `StripeApiClient` | ⚠️ Setup ready |

### Database Schema

Key tables for payment flow:

```
payments (id, amount, payment_method, status, person_id, due_date, paid_at)
├── pix (id, payment_id, bank, key, qr_code, status)
├── bank_slips (id, payment_id, bank, number, due_date, status)
├── persons (id, name, document, email)
├── banks (id, code, name, api_key)
└── countries, states, cities (location hierarchy)
```

### API Endpoints

#### Payment Management
```
POST   /api/payment              # Create payment
GET    /api/payment              # List payments with filters
GET    /api/payment/{id}         # Get payment details
PUT    /api/payment/{id}         # Update payment
DELETE /api/payment/{id}         # Delete payment
```

#### Reports
```
GET /api/payments/report/csv     # Export CSV with filters
GET /api/payments/report/pdf     # Export PDF with filters
```

#### Payment Methods
```
POST   /api/pix/create           # Create Pix
GET    /api/bank-slip/create     # Create Bank Slip
GET    /api/bank-slip/print/{id} # Print Boleto PDF
```

### Enums & Type Safety

**PaymentStatus**
```php
PENDING   // Awaiting processing
PAID      // Successfully paid
FAILED    // Payment failed
EXPIRED   // Payment deadline passed
CANCELLED // Manually cancelled
REVERSED  // Reversal processed
```

**PaymentMethod**
```php
PIX           // Instant payment
BANK_SLIP     // Bank slip (boleto)
CREDIT_CARD   // Credit card (Stripe)
```

### Asynchronous Processing

- **Kafka**: Consumer processes payment events: `php artisan kafka:consume-payments`
- **Redis**: Job queue and caching layer
- **Horizon**: Queue monitoring dashboard: `php artisan horizon`
- **Notifications**: `InvoicePaid` notification on payment creation

### Testing

```bash
# Run all tests
composer test

# Run with code coverage
php artisan test --coverage

# Run specific test class
php artisan test tests/Feature/PaymentTest.php
```

Test coverage includes:
- Feature tests for payment flows
- Integration tests with bank APIs
- Unit tests for services and repositories

### Code Quality

```bash
# Run PHPStan analysis (level 5)
composer analyse

# Format code with Pint
php artisan pint

# Generate Swagger documentation
php artisan l5-swagger:generate
```

### Environment & Configuration

Key `.env` variables:
```
DB_CONNECTION=mysql
REDIS_HOST=redis
KAFKA_BROKERS=kafka:9092
STRIPE_API_KEY=sk_...
NEW_RELIC_ENABLED=true
SENTRY_LARAVEL_DSN=https://...
```

## Implementation Recommendations

### For Stripe Integration
Following the established pattern, create:
1. `StripeController` in `app/Http/Controllers/Payment/`
   - Specific endpoints for Stripe operations (webhooks, charge confirmation, etc.)
   - Separate from generic `PaymentController` for clarity

2. Implement webhook handler:
   ```php
   // Handle Stripe webhook events
   POST /api/stripe/webhook
   ```

3. Services already prepared:
   - `CreditCardService` implements `PaymentMethodInterface`
   - `StripeApiClient` provides API integration
   - Extend with specific Stripe methods as needed

### Future Enhancements
- Add webhook handlers for payment confirmations
- Implement retry mechanisms for failed transactions
- Rate limiting for bank API calls
- Advanced monitoring and alerting
- Contract testing for bank APIs
- Enhanced error recovery strategies

## API Documentation

Generate and view OpenAPI/Swagger documentation:

```bash
# Generate Swagger documentation
php artisan l5-swagger:generate

# Documentation available at:
# http://localhost:8000/api/documentation
```

All endpoints are documented with OpenAPI attributes:
```php
#[OA\Post(
    path: "/api/payment",
    summary: "Create new payment",
    tags: ['Payment'],
    responses: [...]
)]
```

## Deployment

### Docker
```bash
docker-compose up -d
docker exec app composer install
docker exec app php artisan migrate
```

### Kubernetes
Configuration files in `k8s/`:
- `deployment.yaml` - Application deployment
- `service.yaml` - Service exposure
- `ingress.yaml` - Ingress routing
- `secret.yaml` - Environment secrets

## License

MIT
