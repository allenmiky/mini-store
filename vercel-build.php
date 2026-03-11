<?php
echo "🚀 Starting Vercel Build Process...\n";

// Check if we're in Vercel environment
if (file_exists('/opt/homebrew/bin/php') || !file_exists('composer.phar')) {
    echo "📥 Downloading Composer...\n";
    
    // Download composer
    $composerSetup = file_get_contents('https://getcomposer.org/installer');
    file_put_contents('composer-setup.php', $composerSetup);
    
    // Run composer setup with current PHP
    echo "⚙️ Running Composer setup...\n";
    passthru('php composer-setup.php');
    
    // Clean up
    unlink('composer-setup.php');
}

// Check if composer.phar exists
if (!file_exists('composer.phar')) {
    die("❌ Composer.phar not found!\n");
}

// Run composer install
echo "📦 Installing Composer dependencies...\n";
passthru('php composer.phar install --no-dev --optimize-autoloader 2>&1', $returnCode);

if ($returnCode !== 0) {
    die("❌ Composer install failed with code: $returnCode\n");
}

// Laravel optimizations (if Laravel project)
if (file_exists('artisan')) {
    echo "🔧 Running Laravel optimizations...\n";
    passthru('php artisan config:cache 2>&1');
    passthru('php artisan route:cache 2>&1');
    passthru('php artisan view:cache 2>&1');
}

echo "✅ Build completed successfully!\n";