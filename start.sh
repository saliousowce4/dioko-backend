#!/bin/sh

# Clear any old cached config and create a new one based on Render's environment variables
php artisan config:cache

# Run database migrations
php artisan migrate --force

# Start the Apache server in the foreground
apache2-foreground
