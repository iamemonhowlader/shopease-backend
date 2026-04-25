# ShopEase BD - Sales Management System


### 1. Backend Setup (Laravel)
```bash
cd shopease-backend
composer install/update
cp .env.example .env
php artisan key:generate
```
- Configure your database in `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
- Run migrations: `php artisan migrate`
- Start server: `php artisan serve`

### 2. Frontend Setup (Next.js)
```bash
cd shopease-frontend
npm install
```
- Create a `.env.local` file with:
  `NEXT_PUBLIC_API_URL=http://127.0.0.1:8000/api/v1/sales`
- Start development server: `npm run dev`

---

## ⚙️ Environment Variables

### Backend (.env)
- `DB_CONNECTION`: mysql
- `DB_DATABASE`: shopease_db
- `JWT_SECRET`: (Required for API authentication)
- `FILESYSTEM_DISK`: public (to handle import logs)

### Frontend (.env.local)
- `NEXT_PUBLIC_API_URL`: Backend API base URL

---

## 📊 Data Pipeline (Generator & Importer)

### 1. Generate "Dirty" Data
The project includes a Python script to generate 20,000+ rows of realistic but "dirty" sales data (mixed date formats, currency symbols, duplicates).
```bash
cd dirty
python main.py
```
This generates `shopease_dirty.csv`.

### 2. Run Importer
The importer cleans and validates data (normalizing dates, stripping currency symbols, skipping duplicates). Use the API endpoint or the frontend interface to upload the CSV.

---

## 🔌 API Documentation

### 1. Import Sales Data
`POST /api/v1/sales/import`
- **Body**: `file` (form-data, .csv)
- **Response**:
```json
{
  "total": 20000,
  "inserted": 19800,
  "skipped_duplicate": 150,
  "skipped_invalid": 50,
  "error_log_url": "http://.../storage/logs/errors.json"
}
```

### 2. Get Sales List
`GET /api/v1/sales/sales`
- **Query Params**: `branch`, `category`, `payment_method`, `from` (YYYY-MM-DD), `to`
- **Response**: Paginated list of sales records.

### 3. Sales Summary
`GET /api/v1/sales/sales/summary`
- **Response**:
```json
{
  "total_revenue": 1250000.50,
  "total_quantity": 4500,
  "total_orders": 19800,
  "avg_order_value": 63.13,
  "top_products": [...],
  "branch_breakdown": [...]
}
```
### 4. Export Data
- `GET /api/v1/sales/export/csv`: Export current filtered data to CSV.
- `GET /api/v1/sales/export/excel`: Export current filtered data to Excel.
