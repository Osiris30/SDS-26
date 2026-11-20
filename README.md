# SDS26 · Green IoT

Blog de la Semana de Sistemas 2026 de la FMO–UES, construido con Laravel 12 y PostgreSQL. Esta parte incluye acceso de administradores, rutas protegidas, mantenimiento de categorías y filtro público de publicaciones.

## Requisitos

- PHP 8.2 o superior con las extensiones requeridas por Laravel y PostgreSQL (`pdo_pgsql`).
- Composer.
- Node.js y npm.
- Docker Desktop con integración WSL2, o Docker Engine disponible dentro de WSL.

## Preparar el proyecto en WSL2

Desde la carpeta del proyecto:

```bash
cp .env.example .env
composer install
npm install
```

Revisa `.env` antes de iniciar. Configura `ADMIN_EMAIL` y `ADMIN_PASSWORD` con una contraseña propia; la contraseña inicial del ejemplo solo sirve para desarrollo local. El puerto publicado de PostgreSQL es `5433` para evitar interferir con otros proyectos.

Inicia PostgreSQL:

```bash
docker compose up -d db
```

Cuando la base esté saludable, prepara la aplicación:

```bash
php artisan key:generate
php artisan migrate --seed
npm run build
```

El seeder crea el administrador indicado en las variables `ADMIN_EMAIL` y `ADMIN_PASSWORD`, además de tres categorías iniciales. Para iniciar Laravel:

```bash
php artisan serve --host=0.0.0.0
```

Abre `http://localhost:8000`. El acceso administrativo está en `/iniciar-sesion`.

## Desarrollo con recarga automática

En una segunda terminal, ejecuta `npm run dev` para servir los recursos de Vite. Mantén PostgreSQL y `php artisan serve` en ejecución.

## Pruebas

```bash
php artisan test
```

La suite cubre inicio/cierre de sesión, bloqueo de cuentas no administradoras, protección de rutas, CRUD de categorías y filtro de publicaciones.

## Notas de contenido

- Las publicaciones deben tener `is_published = true` y una fecha `published_at` no futura para aparecer en el sitio.
- Al eliminar una categoría, sus publicaciones se conservan y quedan sin categoría.
- El formulario CRUD y las rutas se encuentran en el grupo `/admin/categorias`.
- Cambia las credenciales iniciales antes de compartir o desplegar el proyecto.
