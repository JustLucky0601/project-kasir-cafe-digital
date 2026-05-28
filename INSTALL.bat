@echo off
title BrewLux POS - Installer Otomatis
color 0A

echo.
echo  ============================================
echo   BrewLux POS - Setup Otomatis
echo   Pastikan PHP dan Composer sudah terinstall
echo  ============================================
echo.

:: Check PHP
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] PHP tidak ditemukan!
    echo Silakan install XAMPP dari https://www.apachefriends.org/
    pause
    exit
)

:: Check Composer
composer -V >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Composer tidak ditemukan!
    echo Silakan install dari https://getcomposer.org/
    pause
    exit
)

echo [1/6] Membuat project Laravel...
composer create-project laravel/laravel brewlux-app --prefer-dist --no-interaction
if %errorlevel% neq 0 (
    echo [ERROR] Gagal membuat project Laravel
    pause
    exit
)

echo [2/6] Menyalin file source code...
xcopy /E /Y /Q src\* brewlux-app\

echo [3/6] Membuat file .env...
copy brewlux-app\.env.example brewlux-app\.env
php brewlux-app\artisan key:generate

echo [4/6] Membuat symlink storage...
php brewlux-app\artisan storage:link

echo.
echo  ============================================
echo   PENTING: Setup Database dulu!
echo  ============================================
echo.
echo  1. Buka phpMyAdmin: http://localhost/phpmyadmin
echo  2. Buat database baru: brewlux_pos
echo  3. Edit file brewlux-app\.env:
echo     DB_DATABASE=brewlux_pos
echo     DB_USERNAME=root
echo     DB_PASSWORD=(password MySQL kamu)
echo.
pause

echo [5/6] Menjalankan migration dan seeder...
cd brewlux-app
php artisan migrate --seed
cd ..

echo [6/6] Selesai! Menjalankan server...
echo.
echo  ============================================
echo   Buka browser: http://localhost:8000
echo   Login Admin  : admin / admin123
echo   Login Kasir  : kasir1 / kasir123
echo  ============================================
echo.
cd brewlux-app
php artisan serve
pause
