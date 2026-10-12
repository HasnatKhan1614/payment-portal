# Payment Portal

Laravel-based multi-gateway payment portal for creating invoices, managing customers/brands, and collecting payments through **Stripe**, **PayPal**, and **Authorize.Net**.

## Features

- Admin dashboard for payments, customers, brands, gateways, users, and settings
- Invoice generation and payment links
- Stripe Checkout, PayPal, and Authorize.Net hosted payment flows
- Soft-delete support for core records
- Dummy seed data for local development

## Requirements

- PHP 8.2+
- Composer
- MySQL or SQLite
- Node.js (optional, for frontend assets)

## Quick start

```bash
# 1. Install PHP dependencies
composer install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env, then migrate + seed
php artisan migrate --seed

# 4. Link storage (for brand logos)
php artisan storage:link

# 5. Run the app
php artisan serve
```

Open `http://127.0.0.1:8000`.

## Demo accounts

| Role  | Email               | Password  |
|-------|---------------------|-----------|
| Admin | admin@example.com   | password  |
| User  | user@example.com    | password  |
| Agent | agent@example.com   | password  |

## Seeders

`php artisan db:seed` (or `migrate --seed`) loads:

- Users
- Brands (with dummy logos)
- Gateways (Stripe / PayPal / Authorize.Net sandbox placeholders)
- Customers
- Settings
- Sample payments / invoices

Gateway API keys in seeders are **dummy placeholders** — replace them in the Gateways UI before testing real payments.

## Project structure (high level)

```
app/Http/Controllers   # Payments, customers, brands, gateways, users
app/Services           # PayPal & Authorize.Net integrations
database/seeders       # Dummy data seeders
resources/views        # Blade UI
public/assets/img      # Dummy logos and theme assets
```

## Environment notes

Copy `.env.example` to `.env` and set at least:

- `APP_URL`
- Database credentials (`DB_*`)
- Optional gateway config used by services (`paypal`, `authorizenet` config files)

Never commit your real `.env` or live API keys.

## License

MIT
"# payment-portal" 
