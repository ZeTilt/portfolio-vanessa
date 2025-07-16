#!/bin/bash

# Deployment script for O2Switch
echo "Preparing Symfony project for production deployment..."

# Set production environment
export APP_ENV=prod

# Clear all caches
echo "Clearing cache..."
php bin/console cache:clear --env=prod --no-debug

# Install production dependencies
echo "Installing production dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Warm up the cache
echo "Warming up cache..."
php bin/console cache:warmup --env=prod

# Set proper permissions
echo "Setting permissions..."
chmod -R 755 var/cache var/log

echo "Production build completed!"
echo "You can now upload the files to your O2Switch hosting."
echo ""
echo "Remember to:"
echo "1. Copy .env.prod to .env on the server"
echo "2. Update APP_SECRET in .env with a random 32-character string"
echo "3. Configure email settings if needed"
echo "4. Point your domain to the /public directory"