FROM php:8.2-fpm

# 安裝系統依賴
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    libzip-dev nodejs npm nginx libpq-dev

# 安裝 PHP 擴充套件
RUN docker-php-ext-install pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# 安裝 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 設定工作目錄
WORKDIR /var/www

# 複製專案
COPY . .

# 安裝依賴
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run prod

# 設定權限
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# 複製 nginx 設定
COPY docker/nginx.conf /etc/nginx/sites-available/default

# 啟動腳本
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000

CMD ["/start.sh"]