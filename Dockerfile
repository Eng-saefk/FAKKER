# 1. استخدام نسخة PHP الرسمية مع سيرفر Apache
FROM php:8.2-apache

# 2. تثبيت الإضافات اللازمة للارافيل و Node.js
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libicu-dev \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 3. تفعيل Rewrite في Apache وتثبيت إضافات PHP
RUN a2enmod rewrite && docker-php-ext-install pdo_mysql mbstring gd intl

# 4. تحميل Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. تحديد مسار العمل ونسخ ملفات المشروع
WORKDIR /var/www/html
COPY . .

# 6. تثبيت مكتبات PHP
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 7. بناء ملفات Vite وصلاحيات الـ build
RUN npm install && npm run build \
    && mkdir -p public/build \
    && chown -R www-data:www-data public/build

# 8. إعدادات Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 9. الصلاحيات المطلقة لقاعدة البيانات والمجلدات
RUN mkdir -p database storage bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 777 database storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# 10. التشغيل التلقائي مع إجبار الجلسات على نظام الملفات (لحل مشكلة التعليق)
ENTRYPOINT ["/bin/sh", "-c", "export SESSION_DRIVER=file && php artisan migrate --force && php artisan config:clear && apache2-foreground"]

EXPOSE 80