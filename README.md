## 🛠️ Instalasi

### Persyaratan

- PHP 8.2.8 & Web Server (Apache, Lighttpd, atau Nginx)
- Database (MariaDB v11.0.3 atau PostgreSQL)
- Web Browser (Firefox, Safari, Opera, dll)

### Langkah-langkah

1. **Klon Repositori**

    ```bash
    git clone https://github.com/adirasakhi/ukk-perpus-main-test.git
    cd ukk-perpus-main-test
    composer install
    npm install
    cp .env.example .env
    ```

2. **Konfigurasi Database**

    ```conf
    APP_DEBUG=true
    DB_DATABASE=perpus1
    DB_USERNAME=nama-pengguna-anda
    DB_PASSWORD=kata-sandi-anda
    ```

3. **Migrasi dan Symlink**

    ```bash
    php artisan key:generate
    php artisan storage:link
    php artisan migrate --seed
    ```

4. **Mulai Situs Web**

    ```bash
    npm run dev
    # Jalankan di terminal yang berbeda
    php artisan serve
    ```
