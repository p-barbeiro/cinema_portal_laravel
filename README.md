# CineMagic 
*Internet Applications Project*

---

### Dependencies

> - [MySQL 8.0.30](https://dev.mysql.com/downloads/mysql/)
> - [Nginx 1.22.0](https://nginx.org/en/download.html)
> - [PHP 8.3.6](https://www.php.net/downloads)
> - [Node.js 20.12.2](https://nodejs.org/en/download/)
> - [Composer 2.7.3](https://getcomposer.org/download/)

### .env database configuration
~~~
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=InetAppsProject #nome da bd que estao a usar localmente
DB_USERNAME=root
DB_PASSWORD=root
~~~

### PDF Creator
~~~
composer require spatie/laravel-pdf
~~~
[Documentation](https://spatie.be/docs/laravel-pdf/v1/introduction)

### QR Code
~~~
composer require simplesoftwareio/simple-qrcode
~~~
[Documentation](https://github.com/SimpleSoftwareIO/simple-qrcode)

### Laravel Charts
~~~
composer require laraveldaily/laravel-charts
~~~
[Documentation](https://charts.erik.cat/)

