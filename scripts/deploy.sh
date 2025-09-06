#!/usr/bin/env bash
set -euo pipefail

APP_URL=${APP_URL:-}
DB_NAME=${DB_NAME:-}
DB_USER=${DB_USER:-}
DB_PASS=${DB_PASS:-}
SESSION_DOMAIN=${SESSION_DOMAIN:-}
MAIL_HOST=${MAIL_HOST:-}
MAIL_USER=${MAIL_USER:-}
MAIL_PASS=${MAIL_PASS:-}
DB_HOST=${DB_HOST:-127.0.0.1}
DB_PORT=${DB_PORT:-3306}
MAIL_PORT=${MAIL_PORT:-587}
MAIL_FROM=${MAIL_FROM:-no-reply@${SESSION_DOMAIN}}

step() { echo -e "\033[36m==> $*\033[0m"; }
done_msg() { echo -e "\033[32m✔ $*\033[0m"; }
fail() { echo -e "\033[31m✖ $*\033[0m"; exit 1; }

if [[ -z "$APP_URL" || -z "$DB_NAME" || -z "$DB_USER" || -z "$DB_PASS" || -z "$SESSION_DOMAIN" || -z "$MAIL_HOST" || -z "$MAIL_USER" || -z "$MAIL_PASS" ]]; then
  fail "Missing required envs. Usage: APP_URL=... DB_NAME=... DB_USER=... DB_PASS=... SESSION_DOMAIN=... MAIL_HOST=... MAIL_USER=... MAIL_PASS=... ./scripts/deploy.sh"
fi

cd "$(dirname "$0")/.."

if [[ -f .env ]]; then
  ts=$(date +%Y%m%d-%H%M%S)
  cp .env ".env.backup-$ts"
  done_msg "Backed up existing .env to .env.backup-$ts"
fi

if [[ -f .env.production ]]; then
  cp .env.production .env
  done_msg "Copied .env.production to .env"
else
  fail ".env.production not found"
fi

awk -v app_url="$APP_URL" -v db_host="$DB_HOST" -v db_port="$DB_PORT" -v db_name="$DB_NAME" -v db_user="$DB_USER" -v db_pass="$DB_PASS" \
    -v sess_dom="$SESSION_DOMAIN" -v mail_host="$MAIL_HOST" -v mail_port="$MAIL_PORT" -v mail_user="$MAIL_USER" -v mail_pass="$MAIL_PASS" -v mail_from="$MAIL_FROM" '
  BEGIN{FS=OFS="="}
  /^APP_ENV=/{$2="production"}
  /^APP_DEBUG=/{$2="false"}
  /^APP_URL=/{print "APP_URL=" app_url; next}
  /^DB_HOST=/{print "DB_HOST=" db_host; next}
  /^DB_PORT=/{print "DB_PORT=" db_port; next}
  /^DB_DATABASE=/{print "DB_DATABASE=" db_name; next}
  /^DB_USERNAME=/{print "DB_USERNAME=" db_user; next}
  /^DB_PASSWORD=/{print "DB_PASSWORD=" db_pass; next}
  /^SESSION_DOMAIN=/{print "SESSION_DOMAIN=" sess_dom; next}
  /^SESSION_SECURE_COOKIE=/{print "SESSION_SECURE_COOKIE=true"; next}
  /^SESSION_HTTP_ONLY=/{print "SESSION_HTTP_ONLY=true"; next}
  /^SESSION_SAME_SITE=/{print "SESSION_SAME_SITE=lax"; next}
  /^LOG_CHANNEL=/{print "LOG_CHANNEL=daily"; next}
  /^LOG_LEVEL=/{print "LOG_LEVEL=warning"; next}
  /^MAIL_MAILER=/{print "MAIL_MAILER=smtp"; next}
  /^MAIL_SCHEME=/{print "MAIL_SCHEME=tls"; next}
  /^MAIL_HOST=/{print "MAIL_HOST=" mail_host; next}
  /^MAIL_PORT=/{print "MAIL_PORT=" mail_port; next}
  /^MAIL_USERNAME=/{print "MAIL_USERNAME=" mail_user; next}
  /^MAIL_PASSWORD=/{print "MAIL_PASSWORD=" mail_pass; next}
  /^MAIL_FROM_ADDRESS=/{print "MAIL_FROM_ADDRESS=" mail_from; next}
  {print}
' .env > .env.tmp && mv .env.tmp .env

if ! grep -q '^APP_KEY=' .env || [[ -z "$(grep '^APP_KEY=' .env | cut -d= -f2)" ]]; then
  step "Generating APP_KEY"
  php artisan key:generate --force
fi

step "Composer install (no-dev, optimized)"
composer install --no-dev --optimize-autoloader

step "Run migrations"
php artisan migrate --force

step "Storage link"
php artisan storage:link || true

step "Cache config/routes/views"
php artisan config:cache
php artisan route:cache
php artisan view:cache

step "Install node deps and build assets"
if [[ -f package-lock.json ]]; then npm ci; else npm install; fi
npm run build

done_msg "Deployment steps completed. Point your web server DocumentRoot to the 'public' folder."
