@echo off
REM setup.bat - pełna inicjalizacja środowiska Laravel + PostgreSQL

REM 1. Ustawienie ExecutionPolicy dla PowerShell
powershell -Command "Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy RemoteSigned -Force"

REM 2. Odkomentowanie rozszerzeń w php.ini
REM powershell -Command "(Get-Content 'C:\xampp\php\php.ini') -replace ';extension=pdo_pgsql', 'extension=pdo_pgsql' -replace ';extension=pgsql', 'extension=pgsql' | Set-Content 'C:\xampp\php\php.ini'"
REM echo Sprawdź, czy rozszerzenia pdo_pgsql i pgsql są odkomentowane w php.ini!


REM 3. Tworzenie bazy danych (jeśli nie istnieje)
echo Tworzenie bazy danych ShopDB...
set PGPASSWORD=123
psql -U postgres -h 127.0.0.1 -p 5432 -tc "SELECT 1 FROM pg_database WHERE datname = 'ShopDB'" | find "1" >nul
if errorlevel 1 (
    psql -U postgres -h 127.0.0.1 -p 5432 -c "CREATE DATABASE \"ShopDB\";"
) else (
    echo Baza ShopDB już istnieje.
)

REM 4. Kopiowanie .env.example do .env (jeśli nie istnieje)
if not exist .env (
    copy .env.example .env
)

REM 5. Ustawienie danych do bazy w .env (usuń # jeśli jest na początku linii)
powershell -Command "(Get-Content .env) -replace '^[#\s]*DB_CONNECTION=.*', 'DB_CONNECTION=pgsql' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^[#\s]*DB_HOST=.*', 'DB_HOST=127.0.0.1' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^[#\s]*DB_PORT=.*', 'DB_PORT=5432' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^[#\s]*DB_DATABASE=.*', 'DB_DATABASE=ShopDB' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^[#\s]*DB_USERNAME=.*', 'DB_USERNAME=postgres' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^[#\s]*DB_PASSWORD=.*', 'DB_PASSWORD=123' | Set-Content .env"

REM 6. Instalacja zależności PHP
echo Instalacja zależności Composer...
call composer install

REM 7. Instalacja zależności JS
echo Instalacja zależności NPM...
call npm install

REM 8. Migracje i seed
echo Migracje i seed...
call php artisan migrate:fresh --seed

REM 9. Link do storage
call php artisan storage:link

echo Gotowe! Środowisko przygotowane.

pause