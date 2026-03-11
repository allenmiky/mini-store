#!/bin/bash
echo "🚀 Deploying Laravel Application..."

# 1. Pull latest code
git pull origin main

# 2. Install dependencies
composer install --no-dev --optimize-autoloader
npm ci --production

# 3. Build assets
npm run build

# 4. Clear caches
php artisan optimize:clear

# 5. Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Run migrations
php artisan migrate --force

# 7. Set permissions
chmod -R 775 storage bootstrap/cache

echo "✅ Deployment complete!"