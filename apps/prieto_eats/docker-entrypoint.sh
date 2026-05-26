#!/bin/sh
set -e

echo "⏳ Esperando a que PostgreSQL esté disponible..."
until php -r "
  try {
    \$pdo = new PDO(
      'pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
      getenv('DB_USERNAME'),
      getenv('DB_PASSWORD')
    );
    echo 'ok';
  } catch (Exception \$e) {
    exit(1);
  }
" 2>/dev/null; do
  sleep 2
done

echo "✅ PostgreSQL disponible."

echo "🔧 Ejecutando migraciones..."
php artisan migrate --force

echo "🔗 Creando enlace de almacenamiento..."
php artisan storage:link --force 2>/dev/null || true

echo "⚡ Optimizando Laravel para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🚀 Iniciando Apache..."
exec "$@"
