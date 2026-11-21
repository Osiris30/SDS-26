# Blog SDS26 · Semana de Sistemas 2026

Blog de la carrera de Sistemas de la FMO-UES, construido con Laravel 12. El sitio público presenta las actividades y sus aprendizajes. El panel permite a la administración organizar categorías, redactar entradas, gestionar imágenes y programar publicaciones.

## Requisitos

- PHP 8.2 o superior, Composer y las extensiones requeridas por Laravel.
- Node.js y npm para compilar los estilos.
- PostgreSQL con `pdo_pgsql`.
- Docker Desktop con integración WSL2, o Docker Engine dentro de WSL.

## Preparar en WSL2

Desde la carpeta del proyecto:

```bash
cp .env.example .env
composer install
npm install
```

Revisa `.env`: configura la conexión de PostgreSQL y cambia `ADMIN_EMAIL` y `ADMIN_PASSWORD` por credenciales propias antes de iniciar. El ejemplo configura PostgreSQL en el puerto `5433`.

Inicia el contenedor de base de datos:

```bash
docker compose up -d db
```

Prepara Laravel, las tablas, el usuario administrador y las categorías de las actividades:

```bash
php artisan key:generate
php artisan migrate --seed
npm run build
```

El seeder crea las categorías Ponencias, Talleres, Bingo, Feria de proyectos, Comelona de pizza, Torneo de fútbol sala y Parrillada. Sus descripciones muestran los contenidos mínimos sugeridos en el formulario.

Inicia la aplicación:

```bash
php artisan serve --host=0.0.0.0
```

Abre `http://localhost:8000`. La portada pública es `/`; el acceso administrativo es `/iniciar-sesion` y el panel está en `/admin`.

## Módulos

### Sitio público

- Presentación de la Semana de Sistemas 2026.
- Listado cronológico por fecha de actividad, búsqueda y filtro por categoría.
- Detalle de cada entrada con autores, fecha de actividad y publicación, portada, galería y contenido.
- Los borradores y las publicaciones con fecha futura no son visibles.
- Diseño adaptable a escritorio y teléfono; no requiere cuenta para leer.

### Administración

- Inicio y cierre de sesión, límite de intentos de acceso y protección de rutas para administradores.
- Panel con resumen de publicaciones, borradores, publicaciones programadas y categorías.
- CRUD de publicaciones y categorías.
- Entradas con título, actividad, fecha, categoría, uno o varios autores, contenido, portada y galería.
- Validación de imágenes JPG, PNG o WebP (hasta 5 MB cada una); una portada y hasta ocho imágenes adicionales.
- Guardado como borrador, publicación inmediata o programación por fecha.

## Datos y archivos

Las migraciones describen usuarios, categorias, publicaciones y galeria. Las imagenes se guardan dentro de `public/uploads` y PostgreSQL conserva sus rutas relativas. Al compartir el proyecto, incluye esa carpeta junto con el respaldo de la base de datos. No hace falta ejecutar `php artisan storage:link`.

No se incluyen publicaciones de ejemplo: agrega las historias reales desde el panel. Mantén las reflexiones y evidencias fieles a cada actividad.
