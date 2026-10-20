# Bonnetje Bij

**All your expenses, clearly organized.** Bonnetje Bij is a Laravel expense tracker for recording everyday spending and reviewing it by month and category.

## Features

- Register and sign in with a personal account.
- Add expenses with a title, amount in euros, date, category, and optional note.
- Edit or delete your expenses.
- Review monthly spending totals, transaction counts, daily average, and top category.
- See category totals and a six-month spending chart.
- Filter expenses by month or category, or search by title and note.
- Keep each user's expenses private to their account.

Available categories are Food & drink, Transport, Shopping, Home, Bills, Health, Entertainment, and Other.

## Requirements

- PHP 8.3 or later
- Composer
- Node.js and npm
- SQLite (the default setup) or MySQL/MariaDB

## Installation

Run these commands from the project directory.

### 1. Install dependencies

```sh
composer install
npm install
```

### 2. Configure the environment

Copy `.env.example` to `.env`.

PowerShell:

```powershell
Copy-Item .env.example .env
```

macOS/Linux:

```sh
cp .env.example .env
```

Generate the application key:

```sh
php artisan key:generate
```

### 3. Create the database

The example environment uses SQLite. Create the local database file if it does not already exist.

PowerShell:

```powershell
New-Item database/database.sqlite -ItemType File -Force
```

macOS/Linux:

```sh
touch database/database.sqlite
```

The SQLite file is intentionally excluded from Git. Each developer creates their own local copy.

### 4. Create the tables and build the frontend

```sh
php artisan migrate
npm run build
```

### 5. Start the application

```sh
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000), create an account, and start tracking expenses.

## Using MySQL or MariaDB instead

Create an empty database in MySQL/MariaDB, then update the database settings in `.env`. For example:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bonnetje_bij
DB_USERNAME=root
DB_PASSWORD=
```

Set `DB_DATABASE` to the name of the database you created. Run the migrations after saving `.env`:

```sh
php artisan migrate
```

## User guide

1. Open the site and register an account, or sign in.
2. Select **Add expense** to record a purchase. Enter its description, euro amount, date, and category. Add a note if useful.
3. Return to **Overview** to see your monthly total, daily average, top category, spending chart, and category breakdown.
4. Use the month and category filters or search field to find specific expenses.
5. Select **Edit** beside an expense to change it, or **Delete** to remove it.

The tracker records expenses in euros and supports one expense per entry. It does not currently connect to bank accounts or provide income and budget tracking.

## Development

To run the Vite development server while working on the frontend:

```sh
npm run dev
```

For a production asset build:

```sh
npm run build
```
