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

The project follows a layered architecture:


Controllers
↓
Services
↓
Factories
↓
Bank Clients


### Layers Description

- **Clients** → integrations with bank APIs
- **Services** → business logic
- **Repositories** → data persistence
- **Events / Jobs** → asynchronous processing

## Future Improvements

- Add credit card integrations
- Improve retry mechanisms
- Implement rate limiting for bank APIs
- Expand observability metrics
- Add contract testing for bank APIs

## License

MIT
