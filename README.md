# Prueba técnica para Desarrolladores Backend PHP 👩‍💻🧑‍💻

#### Imagen Dinámica 2021

<br>

El presente repositorio contiene el material necesario para llevar a cabo la prueba técnica en una sesión de live coding que tendrá una duración aproximada de entre 60 y 90 minutos.

<br>

## Requerimientos

- Navegador web
- Git
- PHP (contar composer)
- MySQL
- Editor de código
- Node JS y NPM

<br>

## Instalar el proyecto de forma local

Para instalar el proyecto de forma local deberá clonar el repositorio:

```git clone https://github.com/ChristianID/prueba-tecnica-backend-php.git```

```cd prueba-tecnica-backend-php```

```composer install```

```cp .env.example . .env```
 
*Configure las variables de entorno correspondientes a su base de datos [DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD] que previamente deberá crear en MySQL, MariaDB o PostgreSQL con el nombre que desee, solo asegúrese de establecer este nombre en la configuración.*

Posteriormente corra las migraciones y seeders

```php artisan migrate --seed```

Opcionalmente puede ejecutar:

```php artisan config:cache```

```php artisan route:cache``` 

## Consideraciones

Durante la sesión de live coding se busca observar la experiencia y dominio de los tópicos sobre los cuales la prueba consiste.

Esta prueba tendrá matices específicos de acuerdo a las sesiones previas a esta prueba.
Por favor, revisa con detenimiento el contenido del presente proyecto hecho con Laravel.
