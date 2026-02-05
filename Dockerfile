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
    curl \
    libicu-dev

# تفعيل مود الـ Rewrite في Apache
RUN a2enmod rewrite

# تثبيت إضافات PHP
RUN docker-php-ext-install pdo_mysql mbstring gd intl

# تحميل Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تثبيت Node.js لبناء ملفات Vite
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# تثبيت مكتبات Node وبناء الملفات
COPY package*.json ./
RUN npm install && npm run build

# نسخ ملفات المشروع
COPY . /var/www/html

# إعدادات Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# السطر السحري لتجاوز الخطأ الذي ظهر في صورة image_2132af
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs
RUN chmod -R 777 storage bootstrap/cache database
RUN touch database/database.sqlite && chmod 777 database/database.sqlite
EXPOSE 80