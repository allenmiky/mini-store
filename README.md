<p align="center">
  <img src="https://i.ibb.co/Q75LPQsb/logo.png" alt="Flownex Store Logo" width="140">
</p>

# Flownex Store

Flownex Store is a simple Laravel Blade practice store project.

This is not a production ecommerce application. It is a learning project built to practice:

- Laravel routing
- controllers
- Blade views
- session-based cart flow
- checkout flow
- order pages
- basic admin CRUD structure

## Project Overview

This project is a small Laravel Blade store that demonstrates a basic ecommerce-style flow using server-rendered views.

Main flow:

- product listing
- product detail page
- cart
- checkout
- order success page
- user order history

## Tech Stack

- PHP 8.2
- Laravel 12
- Blade
- MySQL / SQLite
- Vite

## Getting Started

### 1. Open the project

```bash
cd c:\xampp\htdocs\mini-store
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Create the environment file

```bash
copy .env.example .env
php artisan key:generate
```

### 4. Configure the database

Update your `.env` file with your database credentials.

Example for MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_store
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migrations and seeders

```bash
php artisan migrate
php artisan db:seed
```

### 6. Start the frontend build tool

For development:

```bash
npm run dev
```

### 7. Start the Laravel server

```bash
php artisan serve
```

For a production build:

```bash
npm run build
```

Open the app in your browser:

```txt
http://127.0.0.1:8000
```

## Useful Commands

```bash
php artisan serve
php artisan migrate
php artisan db:seed
php artisan route:list
php artisan key:generate
npm run dev
npm run build
```

## Project Structure

```txt
mini-store/
|-- app/
|   |-- Http/Controllers/     # Store, cart, checkout, orders, and admin controllers
|   `-- Models/               # User, Product, Category, Order, OrderItem
|-- config/                   # Laravel configuration files
|-- database/
|   |-- factories/            # Model factories
|   |-- migrations/           # Database schema files
|   `-- seeders/              # Seed data
|-- public/                   # Public assets and entry point
|-- resources/
|   |-- js/                   # Frontend scripts
|   |-- css/                  # Styles
|   `-- views/                # Blade templates
|       |-- cart/
|       |-- checkout/
|       |-- components/
|       |-- orders/
|       `-- store/
|-- routes/
|   |-- auth.php
|   `-- web.php
|-- storage/                  # Logs, cache, and framework files
|-- artisan
|-- composer.json
|-- package.json
|-- vite.config.js
`-- README.md
```

## Main Features

- home/store page
- category-based product browsing
- product details page
- session cart
- coupon support
- checkout form
- order placement
- order success page
- authenticated user order history
- basic admin routes for categories and products

## Notes

- This project is mainly for Laravel Blade practice.
- The cart is session-based.
- The checkout system is basic.
- Payment handling is mock/basic and not a full real-world gateway integration.
- This project is useful for learning Laravel MVC structure and Blade rendering.

## Seeder Note

If admin seeding is configured, check:

- `database/seeders/AdminUserSeeder.php`
- `database/seeders/DatabaseSeeder.php`

## Summary

Flownex Store is a small Laravel Blade practice project built to demonstrate a basic online store workflow using Laravel's server-rendered stack.
