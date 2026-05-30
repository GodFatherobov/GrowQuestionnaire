FROM php:8.2-fpm

# 安裝系統依賴
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    libzip-dev nodejs npm nginx libpq-dev \
    libjpeg-dev libfreetype6-dev

# 安裝 GD（需在 configure 後才能支援 JPEG / FreeType）
RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install gd

# 安裝其他 PHP 擴充套件
RUN docker-php-ext-install pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath zip

# PHP 執行環境設定
RUN echo "memory_limit=512M\nmax_execution_time=120\npost_max_size=64M\nupload_max_filesize=64M" > /usr/local/etc/php/conf.d/custom.ini

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