<p align="center">
  <img src="https://i.ibb.co/Q75LPQsb/logo.png" alt="Mini Store Logo" width="140">
</p>

# Mini Store

Mini Store ek simple **Laravel Blade practice store project** hai.  
Yeh production ecommerce app nahi hai. Is project ka purpose Laravel basics practice karna hai, jaise:

- Blade views
- routing
- controllers
- cart session handling
- checkout flow
- order pages
- basic admin/product management

## Project Type

Yeh sirf ek **Laravel Blade practice store** hai jisme frontend Blade templates ke through render hota hai.  
Isme simple store flow implement kiya gaya hai:

- products listing
- product detail page
- cart
- checkout
- order success page
- basic orders history

## Tech Stack

- PHP 8.2
- Laravel 12
- Blade Templates
- MySQL
- Vite
- Bootstrap / frontend utility classes used in views

## How To Start

### 1. Project clone/open karo

```bash
cd c:\xampp\htdocs\mini-store
```

### 2. Dependencies install karo

```bash
composer install
npm install
```

### 3. Environment file setup karo

```bash
copy .env.example .env
php artisan key:generate
```

### 4. Database configure karo

`.env` file me apni MySQL database details set karo:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_store
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrations aur seeders run karo

```bash
php artisan migrate
php artisan db:seed
```

### 6. Frontend build/run karo

Development ke liye:

```bash
npm run dev
```

Production build ke liye:

```bash
npm run build
```

### 7. Laravel server start karo

```bash
php artisan serve
```

Phir browser me open karo:

```txt
http://127.0.0.1:8000
```

## Useful Commands

```bash
php artisan serve
php artisan migrate
php artisan db:seed
php artisan route:list
npm run dev
npm run build
```

## Project Structure

```txt
mini-store/
├── app/
│   ├── Http/Controllers/     # Store, cart, checkout, orders, admin controllers
│   └── Models/               # User, Product, Category, Order, OrderItem
├── database/
│   ├── migrations/           # Database table structure
│   ├── seeders/              # Demo/admin seed data
│   └── factories/            # Model factories
├── public/                   # Public entry files and assets
├── resources/
│   ├── views/                # Blade templates
│   │   ├── store/            # Store pages
│   │   ├── cart/             # Cart page
│   │   ├── checkout/         # Checkout and success page
│   │   ├── orders/           # Orders history and details
│   │   └── components/       # Reusable Blade components
│   ├── css/                  # Styles
│   └── js/                   # Frontend scripts
├── routes/
│   ├── web.php               # Main web routes
│   └── auth.php              # Authentication routes
├── storage/                  # Logs, cache, framework files
├── config/                   # Laravel config files
├── artisan                   # Laravel CLI entry point
├── composer.json             # PHP dependencies
├── package.json              # Node dependencies
├── vite.config.js            # Vite config
└── README.md
```

## Main Features

- home/store page
- category based browsing
- product details page
- session cart
- coupon apply flow
- checkout form
- order placement
- order success page
- authenticated user orders page
- basic admin routes for categories and products

## Notes

- Yeh project learning/practice ke liye bana hua hai.
- Cart session based hai.
- Checkout flow basic implementation hai.
- Payment integrations real gateway based nahi hain.
- Is project ko Laravel Blade structure samajhne ke liye use kiya ja sakta hai.

## Admin Seeder

Agar admin user se related seeder configured hai, to database seed ke baad admin login use kar sakte ho.  
Seeder files check karo:

- `database/seeders/AdminUserSeeder.php`
- `database/seeders/DatabaseSeeder.php`

## Summary

Mini Store ek small Laravel Blade practice project hai jo ecommerce-like flow ko simple tareeqe se demonstrate karta hai.  
Yeh project Laravel routing, controllers, Blade, sessions, migrations, aur CRUD concepts practice karne ke liye useful hai.
