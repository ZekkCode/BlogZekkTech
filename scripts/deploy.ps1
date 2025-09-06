Param(
    [Parameter(Mandatory = $true)][string]$AppUrl,
    [Parameter(Mandatory = $true)][string]$DbName,
    [Parameter(Mandatory = $true)][string]$DbUser,
    [Parameter(Mandatory = $true)][string]$DbPass,
    [Parameter(Mandatory = $true)][string]$SessionDomain,
    [Parameter(Mandatory = $true)][string]$MailHost,
    [Parameter(Mandatory = $true)][string]$MailUser,
    [Parameter(Mandatory = $true)][string]$MailPass,
    [string]$DbHost = "127.0.0.1",
    [string]$DbPort = "3306",
    [string]$MailPort = "587",
    [string]$MailFrom = "no-reply@$SessionDomain",
    [switch]$SkipNpm
)

function Step($msg) { Write-Host "==> $msg" -ForegroundColor Cyan }
function Done($msg) { Write-Host "✔ $msg" -ForegroundColor Green }
function Fail($msg) { Write-Host "✖ $msg" -ForegroundColor Red; exit 1 }

try {
    $root = Split-Path -Parent $MyInvocation.MyCommand.Definition
    Set-Location (Resolve-Path "$root/..")

    if (Test-Path .env) {
        $ts = Get-Date -Format "yyyyMMdd-HHmmss"
        Copy-Item .env ".env.backup-$ts" -Force
        Done "Backed up existing .env to .env.backup-$ts"
    }

    if (Test-Path .env.production) {
        Copy-Item .env.production .env -Force
        Done "Copied .env.production to .env"
    }
    else {
        Fail ".env.production not found"
    }

    $envContent = Get-Content .env -Raw
    $repl = @{
        'APP_ENV'               = 'production'
        'APP_DEBUG'             = 'false'
        'APP_URL'               = $AppUrl
        'DB_HOST'               = $DbHost
        'DB_PORT'               = $DbPort
        'DB_DATABASE'           = $DbName
        'DB_USERNAME'           = $DbUser
        'DB_PASSWORD'           = $DbPass
        'SESSION_DOMAIN'        = $SessionDomain
        'SESSION_SECURE_COOKIE' = 'true'
        'SESSION_HTTP_ONLY'     = 'true'
        'SESSION_SAME_SITE'     = 'lax'
        'LOG_CHANNEL'           = 'daily'
        'LOG_LEVEL'             = 'warning'
        'MAIL_MAILER'           = 'smtp'
        'MAIL_SCHEME'           = 'tls'
        'MAIL_HOST'             = $MailHost
        'MAIL_PORT'             = $MailPort
        'MAIL_USERNAME'         = $MailUser
        'MAIL_PASSWORD'         = $MailPass
        'MAIL_FROM_ADDRESS'     = $MailFrom
        'MAIL_FROM_NAME'        = '${APP_NAME}'
    }

    foreach ($key in $repl.Keys) {
        $val = $repl[$key]
        if ($key -eq 'MAIL_FROM_NAME') { continue }
        $pattern = "(?m)^$key=.*$"
        if ($envContent -match $pattern) {
            $envContent = [Regex]::Replace($envContent, $pattern, "$key=$val")
        }
        else {
            $envContent += "`n$key=$val"
        }
    }

    # Ensure APP_ENV/APP_DEBUG
    $envContent = [Regex]::Replace($envContent, '(?m)^APP_ENV=.*$', 'APP_ENV=production')
    $envContent = [Regex]::Replace($envContent, '(?m)^APP_DEBUG=.*$', 'APP_DEBUG=false')

    Set-Content .env $envContent -NoNewline
    Done "Wrote production settings to .env"

    # Generate APP_KEY if empty
    $hasKey = (Select-String -Path .env -Pattern '(?m)^APP_KEY=.+').Matches.Count -gt 0
    if (-not $hasKey) {
        Step "Generating APP_KEY"
        php artisan key:generate --force | Out-Host
    }

    Step "Composer install (no-dev, optimized)"
    composer install --no-dev --optimize-autoloader | Out-Host

    Step "Run migrations"
    php artisan migrate --force | Out-Host

    Step "Storage link"
    php artisan storage:link | Out-Host

    Step "Cache config/routes/views"
    php artisan config:cache | Out-Host
    php artisan route:cache | Out-Host
    php artisan view:cache | Out-Host

    if (-not $SkipNpm) {
        Step "Install node deps and build assets"
        if (Test-Path package-lock.json) { npm ci | Out-Host } else { npm install | Out-Host }
        npm run build | Out-Host
    }

    Done "Deployment steps completed"
    Write-Host "Remember to point your web server DocumentRoot to the 'public' folder." -ForegroundColor Yellow
}
catch {
    Fail $_.Exception.Message
}
