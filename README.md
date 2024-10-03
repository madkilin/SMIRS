## 🛠️ Instalasi

### Persyaratan

- PHP 8.2.8 & Web Server (Apache, Lighttpd, atau Nginx)
- Database (MariaDB v11.0.3 atau PostgreSQL)
- Web Browser (Firefox, Safari, Opera, dll)

### Langkah-langkah

1. **Klon Repositori**

    ```bash
    git clone https://github.com/madkilin/SMIRS.git
    cd SMIRS
    composer install (or composer update)
    cp .env.example .env
    ```

2. **Konfigurasi Database**

    ```conf
    APP_DEBUG=true
    DB_DATABASE=db_smirs
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
    php artisan serve
    ```
