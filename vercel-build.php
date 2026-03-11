<?php
echo "🚀 Starting Vercel Build Process...\n";

// Run composer commands
echo "📦 Installing Composer dependencies...\n";
passthru('composer install --no-dev --optimize-autoloader');

echo "🔧 Running Laravel optimizations...\n";
passthru('php artisan config:cache');
passthru('php artisan route:cache');
passthru('php artisan view:cache');

echo "✅ Build completed successfully!\n";