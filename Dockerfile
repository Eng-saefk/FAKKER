# استخدام نسخة PHP الرسمية مع سيرفر Apache
FROM php:8.2-apache

# تثبيت الإضافات اللازمة للارافيل
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# تفعيل مود الـ Rewrite في Apache (ضروري للروابط)
RUN a2enmod rewrite

# تثبيت إضافات PHP الخاصة بقاعدة البيانات
RUN docker-php-ext-install pdo_mysql mbstring gd

# تحميل Composer داخل السيرفر
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملفات مشروعك للسيرفر
COPY . /var/www/html

# تحديد المجلد الرئيسي للموقع (الموجود فيه index.php)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# إعطاء الصلاحيات اللازمة لمجلدات لارافيل
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# تشغيل Composer لتثبيت المكتبات
RUN composer install --no-dev --optimize-autoloader

# تعيين المنفذ (Port)
EXPOSE 80