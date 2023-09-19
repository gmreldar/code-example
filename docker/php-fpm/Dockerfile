# Используем базовый образ PHP версии 7.3 с поддержкой FastCGI Process Manager (FPM).
FROM php:8.1-fpm

# Установка переменной окружения для ограничения памяти Composer.
ENV COMPOSER_MEMORY_LIMIT='-1'

# Обновление списка пакетов и установка необходимых зависимостей.
RUN apt-get update && \
    apt-get install -y --force-yes --no-install-recommends \
        libmemcached-dev \
        libzip-dev \
        libz-dev \
        libzip-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        openssh-server \
        libmagickwand-dev \
        git \
        cron \
        nano \
        libxml2-dev \
        libreadline-dev \
        libgmp-dev \
        mariadb-client \
        unzip \
        ffmpeg

# Устанавливаем расширение PHP для работы с SOAP.
RUN docker-php-ext-install soap

# Устанавливаем расширение PHP для обработки изображений.
RUN docker-php-ext-install exif

# Устанавливаем расширение PHP pcntl.
RUN docker-php-ext-install pcntl

# Устанавливаем расширение PHP для работы с архивами zip.
RUN docker-php-ext-install zip

# Устанавливаем расширение PHP для поддержки работы с MySQL.
RUN docker-php-ext-install pdo_mysql

# Устанавливаем расширение PHP для поддержки работы с PostgreSQL.
RUN docker-php-ext-install pdo_pgsql

# Устанавливаем расширение PHP для математических операций.
RUN docker-php-ext-install bcmath

# Устанавливаем расширение PHP для работы с мультиязычностью.
RUN docker-php-ext-install intl

# Устанавливаем расширение PHP для работы с числами GMP (многозначная точность).
RUN docker-php-ext-install gmp


#####################################
# Mongo:
#####################################

# Устанавливаем расширение MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

#####################################
# PHPRedis:
#####################################
RUN pecl install redis && docker-php-ext-enable redis

#####################################
# Imagick:
#####################################

RUN pecl install imagick && \
    docker-php-ext-enable imagick

#####################################
# GD:
#####################################

# Install the PHP gd library
RUN docker-php-ext-install gd && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

#####################################
# xDebug:
#####################################

# Install the xdebug extension
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

#####################################
# Composer:
#####################################

# Устанавливаем Composer и добавляем его бинарник в переменную PATH.
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer


ADD ./laravel.ini /usr/local/etc/php/conf.d

# Сохраняем изменения в .bashrc и исходном .bashrc.
RUN . ~/.bashrc

# Добавляем пользователю www-data идентификатор 1000.
RUN usermod -u 1000 www-data

# Устанавливаем рабочую директорию.
WORKDIR /var/www/html

# Копируем скрипт docker-entrypoint.sh и настраиваем его права.
COPY ./docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
RUN ln -s /usr/local/bin/docker-entrypoint.sh /

# Устанавливаем точку входа (entrypoint) для контейнера.
ENTRYPOINT ["docker-entrypoint.sh"]

# Открываем порт 9000 для PHP-FPM.
EXPOSE 9000

# Запускаем PHP-FPM при старте контейнера.
CMD ["php-fpm"]
