@echo off
title ROTU NAVY - Queue Worker
color 0A

echo ========================================
echo   ROTU NAVY Queue Worker
echo ========================================
echo.
echo Starting queue worker...
echo Press Ctrl+C to stop
echo.

:loop
php artisan queue:work --sleep=3 --tries=3 --timeout=60
echo.
echo [%date% %time%] Queue worker stopped. Restarting in 5 seconds...
timeout /t 5 /nobreak > nul
goto loop
