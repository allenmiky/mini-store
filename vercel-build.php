<?php
echo "🚀 Starting Vercel Build Process...\n";

// Check if composer.phar exists, if not download it
if (!file_exists('composer.phar')) {
    echo "📥 Downloading Composer...\n";
    passthru('curl -sS https://getcomposer.org/installer | php');
}

// Run composer commands using composer.phar
echo "📦 Installing Composer dependencies...\n";
passthru('php composer.phar install --no-dev --optimize-autoloader');

echo "🔧 Running Laravel optimizations...\n";
passthru('php artisan config:cache');
passthru('php artisan route:cache');
passthru('php artisan view:cache');

echo "✅ Build completed successfully!\n";