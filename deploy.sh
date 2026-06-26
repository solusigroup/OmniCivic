#!/bin/bash

echo "Memulai proses deployment OmniCivic..."

# Aktifkan mode pemeliharaan
echo "Mengaktifkan mode pemeliharaan..."
php artisan down || true

# 1. Memeriksa repository di GitHub
echo "Tarik pembaruan terbaru dari repositori (git pull origin main)..."
git pull origin main

# 2. Memeriksa dan memperbarui dependensi Composer
echo "Memeriksa pembaruan Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Bersihkan dan optimalkan cache Laravel
echo "Membersihkan dan memuat ulang cache Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Memeriksa migrasi dan db seed
echo "Menjalankan migrasi database dan db:seed..."
php artisan migrate --force
php artisan db:seed --force

# Matikan mode pemeliharaan
echo "Mematikan mode pemeliharaan..."
php artisan up

echo "Deployment OmniCivic berhasil diselesaikan!"
