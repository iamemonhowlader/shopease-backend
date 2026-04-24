# Shopease Backend

A Laravel 12 API backend for Shopease with CSV import, CSV/Excel export, custom generator commands, JWT auth, and dashboard support.


### Install

```sh
git clone https://github.com/iamemonhowlader/shopease-backend.git
cd shopease-backend
composer install
npm install
cp .env.example .env
```

### Configure environment

Open `.env` and update the database and app settings.

```env
APP_NAME=laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
PHP_CLI_SERVER_WORKERS=4
BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="${APP_NAME}"
DB_USERNAME= {dbusername}
DB_PASSWORD={dbpassword}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379



AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

JWT_SECRET=
```

### Database setup

```sh
php artisan key:generate
php artisan jwt:secret
php artisan migrate
```

```sh
php artisan serve
```

## Dependencies

### PHP packages

- php ^8.2
- laravel/framework ^12.0
- laravel/sanctum ^4.0
- laravel/socialite ^5.19
- laravel/tinker ^2.10.1
- league/csv
- maatwebsite/excel ^3.1
- tymon/jwt-auth ^2.2
- yajra/laravel-datatables 12.0

### Dev packages

- fakerphp/faker ^1.23
- laravel/breeze ^2.3
- laravel/pail ^1.2.2
- laravel/pint ^1.13
- laravel/sail ^1.41
- mockery/mockery ^1.6
- nunomaduro/collision ^8.6
- pestphp/pest ^3.8
- pestphp/pest-plugin-laravel ^3.1

### Node packages

- @tailwindcss/forms
- @tailwindcss/vite
- alpinejs
- autoprefixer
- axios
- concurrently
- laravel-vite-plugin
- postcss
- tailwindcss
- vite

### Endpoint

```http
POST /api/v1/sales/import
Content-Type: multipart/form-data
Authorization: Bearer <token>
```

### Request body

- `file`: CSV or TXT file, max 50MB

### Expected CSV headers

- `sale_id`
- `branch`
- `sale_date`
- `product_name`
- `category`
- `quantity`
- `unit_price`
- `discount_pct`
- `payment_method`
- `salesperson`

### Success response

```json
{
  "total": 120,
  "inserted": 110,
  "skipped_duplicate": 8,
  "skipped_invalid": 2,
  "error_log_url": "http://localhost/storage/logs/import_errors_1680000000.json"
}
```

### Error response

```json
{
  "message": "Validation error",
  "errors": {
    "file": ["The file field is required."]
  }
}
```

## Exporter

Sales export endpoints support filter parameters.

### CSV export

```http
GET /api/v1/sales/export/csv?branch=Dhaka&from=2026-01-01&to=2026-03-31&category=Electronics
Authorization: Bearer <token>
```

Returns a streamed CSV download with columns:

- `Sale ID`
- `Branch`
- `Date`
- `Product`
- `Category`
- `Qty`
- `Price`
- `Discount`
- `Payment`
- `Salesperson`
- `Revenue`

If the result set is large (> 10,000 rows), the endpoint returns a processing response:

```json
{
  "job_id": "csv_export_642b8f4e44e7c",
  "status": "processing",
  "message": "Large file detected. Processing in background."
}
```

### Excel export

```http
GET /api/v1/sales/export/excel?branch=Dhaka&from=2026-01-01&to=2026-03-31&category=Electronics
Authorization: Bearer <token>
```

This returns a `.xlsx` download containing:

- `Sales Data` sheet with filtered sale rows
- `Summary` sheet with branch breakdown totals

If the result set is large (> 10,000 rows), it returns:

```json
{
  "job_id": "excel_export_642b8f4e44e7c",
  "status": "processing"
}
```
## API routes

The key API routes are:

- `POST /api/v1/sales/import`
- `GET /api/v1/sales/sales`
- `GET /api/v1/sales/sales/summary`
- `GET /api/v1/sales/export/csv`
- `GET /api/v1/sales/export/excel`

## Notes

- The importer cleans CSV rows using `CsvCleaningService`.
- Duplicate `sale_id` rows are skipped during insert.
- For local uploads, `php artisan storage:link` is required to expose `storage/app/public`.
- `JWT_SECRET` should be generated once per environment.
