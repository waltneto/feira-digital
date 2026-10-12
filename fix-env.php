<?php
// Script para criar .env correto
$envContent = 'APP_NAME="Feira Digital"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_KEY=

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=file
SESSION_LIFETIME=120

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

CACHE_DRIVER=file
QUEUE_CONNECTION=sync';

file_put_contents('.env', $envContent);

echo "✅ Arquivo .env criado com sucesso!\n";
echo "Execute agora: php artisan key:generate\n";