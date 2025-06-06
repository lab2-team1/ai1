@echo off
REM setup.bat - pełna inicjalizacja środowiska Laravel + PostgreSQL

REM 1. Tworzenie bazy danych (jeśli nie istnieje)
echo Tworzenie bazy danych ShopDB...
psql -U postgres -h 127.0.0.1 -p 5432 -tc "SELECT 1 FROM pg_database WHERE datname = 'ShopDB'" | find "1" >nul
if errorlevel 1 (
    psql -U postgres -h 127.0.0.1 -p 5432 -c "CREATE DATABASE \"ShopDB\";"
) else (
    echo Baza ShopDB już istnieje.
)

REM 2. Kopiowanie .env.example do .env (jeśli nie istnieje)
if not exist .env (
    copy .env.example .env
)

REM 3. Ustawienie danych do bazy w .env
powershell -Command "(Get-Content .env) -replace 'DB_DATABASE=.*', 'DB_DATABASE=ShopDB' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_USERNAME=.*', 'DB_USERNAME=postgres' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_PASSWORD=.*', 'DB_PASSWORD=123' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_CONNECTION=.*', 'DB_CONNECTION=pgsql' | Set-Content .env"

REM 4. Instalacja zależności PHP
echo Instalacja zależności Composer...
call composer install

REM 5. Instalacja zależności JS
echo Instalacja zależności NPM...
call npm install

REM 6. Migracje i seed
echo Migracje i seed...
call php artisan migrate:fresh --seed

REM 7. Link do storage
call php artisan storage:link

echo Gotowe! Środowisko przygotowane.
pause