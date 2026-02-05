FROM php:8.2-apache

# 1. تثبيت المتطلبات
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libicu-dev \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 2. إضافات PHP و Apache
RUN a2enmod rewrite && docker-php-ext-install pdo_mysql mbstring gd intl

# 3. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. نسخ المشروع
WORKDIR /var/www/html
COPY . .

# 5. تثبيت المكتبات وبناء الأصول
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs
RUN npm install && npm run build

# 6. إعدادات Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 7. أهم خطوة: الصلاحيات الشاملة
RUN mkdir -p database storage bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 777 database storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# 8. التشغيل مع تنظيف الكاش وإجبار الـ File Session
ENTRYPOINT ["/bin/sh", "-c", "php artisan config:clear && php artisan migrate --force && apache2-foreground"]
RUN chmod -R 777 /var/www/html/database /var/www/html/storage
EXPOSE 80