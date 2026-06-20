#!/bin/bash
# Run this after every deployment to maximize performance
# Usage: bash optimize.sh

echo "🚀 Optimizing U Super Shop..."

# Cache config, routes, views for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Clear old cache
php artisan cache:clear
php artisan opcache:clear 2>/dev/null || true

echo "✅ Optimization complete!"
echo ""
echo "Performance tips for high traffic (10,000+ users):"
echo "  1. Enable OPcache in php.ini: opcache.enable=1, opcache.memory_consumption=256"
echo "  2. Use Redis for sessions: SESSION_DRIVER=redis in .env"
echo "  3. Use Redis for cache: CACHE_DRIVER=redis in .env"
echo "  4. Set QUEUE_CONNECTION=database for background jobs"
echo "  5. Enable MySQL query cache or use a read replica"
