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

# 6. تثبيت مكتبات PHP (مع تجاهل قيود المنصة)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 7. تثبيت مكتبات Node وبناء ملفات Vite (لحل مشكلة التنسيق والألوان)
RUN npm install && npm run build

# 8. إعدادات Apache لتوجه السيرفر لمجلد public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 9. إعداد الصلاحيات الأولية وقاعدة البيانات
RUN mkdir -p database storage bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 777 database storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# 10. الضربة القاضية: تشغيل المهاجريشن تلقائياً عند كل تشغيل للسيرفر
# السطر ده بيضمن إن جدول sessions يتخلق أول ما الموقع يفتح
ENTRYPOINT ["/bin/sh", "-c", "php artisan migrate --force && apache2-foreground"]

EXPOSE 80