#!/bin/bash

echo "Memulai proses deployment OmniCivic..."

# Tarik pembaruan terbaru dari repositori
echo "Melakukan git pull..."
git pull


# Aktifkan mode pemeliharaan
php artisan down || true

# Bersihkan dan optimalkan cache Laravel
echo "Membersihkan dan memuat ulang cache..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi database
echo "Menjalankan migrasi database..."
php artisan migrate --force

# Matikan mode pemeliharaan
php artisan up

echo "Deployment OmniCivic berhasil diselesaikan!"
