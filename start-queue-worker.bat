@echo off
title ROTU NAVY Queue Worker
d:
cd \xampp\htdocs\ROTU_NAVY

echo ========================================
echo ROTU NAVY Queue Worker Started
echo ========================================
echo.
echo This window will process email notifications automatically.
echo Keep this window open while developing.
echo.
echo Press Ctrl+C to stop the worker.
echo ========================================
echo.

:loop
php artisan queue:work database --sleep=3 --tries=3 --max-time=3600 --timeout=60
if errorlevel 1 (
    echo Worker stopped with error. Restarting in 5 seconds...
) else (
    echo Worker stopped. Restarting in 5 seconds...
)
timeout /t 5 /nobreak
goto loop
