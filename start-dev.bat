@echo off
rem Démarre MySQL (si port 3306 libre) puis le serveur Laravel.
setlocal

netstat -an | findstr ":3306" | findstr "LISTENING" >nul
if %errorlevel%==0 (
  echo [INFO] MySQL deja demarre (port 3306).
) else (
  echo [INFO] Demarrage de MySQL (MariaDB)...
  start "MySQL" "C:\xampp\mysql\bin\mysqld.exe" --defaults-file=C:\xampp\mysql\bin\my.ini
  timeout /t 10 /nobreak >nul
)

echo [INFO] Demarrage du serveur Laravel sur http://127.0.0.1:8000
php artisan serve --host=127.0.0.1 --port=8000

endlocal