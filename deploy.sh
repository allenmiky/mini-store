#!/bin/bash
echo "🚀 Starting Vercel Build..."

# Download Composer if not exists
if [ ! -f "composer.phar" ]; then
    echo "📥 Downloading Composer..."
    curl -sS https://getcomposer.org/installer | php
fi

# Install dependencies
echo "📦 Installing dependencies..."
php composer.phar install --no-dev --optimize-autoloader

# Laravel optimizations
if [ -f "artisan" ]; then
    echo "🔧 Caching Laravel config..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "✅ Build complete!"