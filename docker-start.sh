#!/bin/sh
set -e

php artisan config:clear
php artisan migrate --force

# Solo el primer despliegue: RUN_SEED=true en Render, luego se quita
if [ "$RUN_SEED" = "true" ]; then
  php artisan db:seed --force
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"