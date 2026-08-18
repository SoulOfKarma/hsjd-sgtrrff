# Guía de instalación — SGTRRFF (Laravel 7 + Vue 2)

Guía para levantar este proyecto desde cero en un equipo nuevo. El proyecto es un
monolito **Laravel 7** que sirve una **SPA en Vue 2** (compilada con Laravel Mix,
plantilla admin Vuexy). No hay Docker ni `.env.example` originales — todo lo de
abajo se dedujo leyendo `composer.json`, `package.json`, `config/*.php` y las
migraciones reales del proyecto.

## 0. Resumen de versiones exactas

| Componente | Versión requerida | De dónde sale |
|---|---|---|
| PHP | `^7.2.5` (o sea 7.2.5 – 7.4.x, **no** PHP 8) | `composer.json` |
| Composer | 1.x o 2.x (cualquiera sirve con PHP 7.4) | — |
| MySQL | 5.7+ / 8.0, o MariaDB 10.2+ | migraciones usan `utf8mb4` con índices únicos largos; en MySQL 5.6 fallará el migrate |
| Node.js | 14.x LTS | `node-sass ^4.0.0` y `@vue/cli-service ^3.7.0` no compilan bien en Node 16+ |
| npm | la que trae Node 14 (6.x) | — |
| wkhtmltopdf | cualquiera reciente, **para Windows** | ruta hardcodeada en `config/snappy.php` |

> ⚠️ PHP 7.4 está EOL (sin parches de seguridad desde nov. 2022). Esta guía instala
> lo que el código realmente necesita para correr tal cual está; migrar a PHP 8 es
> un trabajo aparte (Laravel 7 no es compatible con PHP 8 sin parches).

Ya tienes **Laragon** instalado en este equipo — es el camino más simple porque
permite tener varias versiones de PHP en paralelo sin pisar otros proyectos.

## 1. Instalar PHP 7.4

**Opción A — Laragon (recomendada, ya lo tienes instalado):**
1. Abre Laragon → botón derecho sobre el ícono → `PHP` → `Version` → si no aparece 7.4,
   usa `Laragon` → `Tools` → `Quick add` → `PHP 7.4` (o descarga el zip de PHP 7.4 x64
   Thread Safe desde https://windows.php.net/download/ y descomprímelo en
   `C:\laragon\bin\php\php-7.4.x-...`).
2. Selecciona PHP 7.4 como versión activa para este proyecto.
3. En `php.ini` de esa versión, habilita (quita el `;`):
   `extension=openssl`, `extension=pdo_mysql`, `extension=mbstring`,
   `extension=fileinfo`, `extension=gd`, `extension=zip`, `extension=curl`,
   `extension=bcmath`.

**Opción B — PHP standalone:** descarga PHP 7.4 (Non Thread Safe si vas a usar
CLI + servidor web aparte, o Thread Safe si usarás Apache con mod_php) de
windows.php.net, agrégalo al `PATH`, y habilita las mismas extensiones de arriba
en `php.ini`.

Verifica:
```bash
php -v        # debe mostrar 7.4.x
php -m        # debe listar: openssl, pdo_mysql, mbstring, gd, zip, curl, bcmath, fileinfo
```

## 2. Instalar Composer

Descarga el instalador desde https://getcomposer.org/download/ (o usa el que trae
Laragon en `Tools` → `Quick add` → `Composer`). Verifica:
```bash
composer -V
```

## 3. Instalar MySQL

**Opción A:** el MySQL que trae Laragon (`Laragon` → `Menu` → `MySQL` para
arrancarlo/pararlo). Usuario por defecto `root` sin contraseña.

**Opción B:** MySQL Community Server 8.0 standalone, o MariaDB 10.6+.

Crea la base de datos vacía (nombre libre, ejemplo `sgtrrff`):
```sql
CREATE DATABASE sgtrrff CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 4. Instalar Node.js 14 LTS

Este proyecto usa `node-sass` 4.x, que **no compila** en Node 16+ sin dolores de
cabeza. Usa un gestor de versiones para no pisar otros proyectos que uses:

```bash
# con nvm-windows (https://github.com/coreybutler/nvm-windows)
nvm install 14.21.3
nvm use 14.21.3
node -v   # v14.21.3
npm -v
```

## 5. Instalar wkhtmltopdf (generación de PDF)

`config/snappy.php` apunta directo a:
```
C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf
```
Descarga el instalador de https://wkhtmltopdf.org/downloads.html e instálalo
en esa ruta por defecto (el instalador de Windows ya propone ese path).

Si prefieres no tocar `Program Files`, el proyecto también trae el binario vía
Composer (`wemersonjanuario/wkhtmltopdf-windows`, se instala en el paso 7). En
ese caso edita `config/snappy.php` y cambia la línea `'binary' => '"C:\Program
Files\wkhtmltopdf\bin\wkhtmltopdf"'` por la alternativa ya comentada dos líneas
más abajo en el mismo archivo (`vendor\wemersonjanuario\...`).

## 6. Clonar el proyecto

```bash
git clone <url-del-repo> sgtrrff
cd sgtrrff
```

## 7. Backend (Laravel)

```bash
composer install
copy .env.example .env      # (usa `cp` si estás en Git Bash/WSL)
php artisan key:generate
```

Edita `.env` y ajusta al menos:
```
DB_DATABASE=sgtrrff
DB_USERNAME=root
DB_PASSWORD=
APP_URL=http://localhost:8000
MIX_APP_URL=http://localhost:8000
```

Genera la clave de JWT (el login usa `tymon/jwt-auth`, no Passport aunque esté
instalado):
```bash
php artisan jwt:secret
```

Corre las migraciones (89 migraciones + las que trae Passport internamente) y
crea el usuario admin con el seeder:
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

`php artisan db:seed` corre `AdminUserSeeder` (agregado en este cambio) y deja
un usuario administrador listo para entrar:

```
RUN:      11111111-1
Password: Admin123!
```

> El seeder también crea un registro mínimo en `edificios`, `servicios`,
> `unidad_esps` y `cargo_usuarios` porque `users` exige esos IDs (`NOT NULL`) —
> son placeholders, cámbialos desde el panel admin una vez adentro. Es seguro
> volver a correr `php artisan db:seed`: no duplica nada si el admin ya existe.

Nota sobre roles: este proyecto no tiene una tabla de "roles" — el nivel de
acceso lo decide `permiso_usuario` en `tbl_permiso_usuarios`
(`LoginController.php` / `Login.vue`): `1` = Agente, `2` = Admin (lleva a
`/adminView`), `3` = Trabajador, `4` = Usuario general. El seeder crea el admin
con `permiso_usuario = 2`.

## 8. Frontend (Vue)

```bash
npm install
npm run dev          # build de desarrollo (rápido, sin minificar)
# o
npm run watch         # como dev, pero recompila solo al guardar
# o para producción
npm run production
```

Si `npm install` falla compilando `node-sass`, confirma que estás en Node 14
(`node -v`) y vuelve a intentar. Como último recurso: `npm install --legacy-peer-deps`.

## 9. Levantar el servidor

```bash
php artisan serve
```

Abre `http://localhost:8000` — ahí debería cargar la SPA de Vue servida por
Laravel, con el login pidiendo RUN y contraseña.

Si usas Laragon en vez de `artisan serve`: apunta el vhost/Apache al directorio
`public/` del proyecto (Laragon lo hace automático si el proyecto vive dentro de
`laragon/www/`), y entra por el dominio `.test` que te asigne Laragon en vez de
`localhost:8000` — en ese caso ajusta `APP_URL`/`MIX_APP_URL` en `.env` a esa
URL y vuelve a correr `npm run dev`.

## 10. Verificación rápida

- `http://localhost:8000` carga el login (no un error 500).
- Login con `RUN: 11111111-1` / `Password: Admin123!` entra a `/home` (vistas
  de `adminView`).
- Si el login da `500`, revisa `storage/logs/laravel.log` — casi siempre es
  `JWT_SECRET` vacío (paso 7) o la BD sin migrar.

## Problemas conocidos del proyecto (no son tuyos, son de cómo se armó)

- **`AuthServiceProvider.php`** llama `Passport::loadKeysFrom('/storage')` — una
  ruta absoluta a la raíz del disco, no a `storage/` del proyecto. Passport no
  se usa para el login real (eso lo hace JWT), así que normalmente no se nota;
  si algún día ves errores de "private key not found" al tocar rutas
  `/oauth/*`, es por esto.
- **`config/database.php`** tiene un IP interna hardcodeada como valor por
  defecto de `DB_HOST` (`10.66.248.51`) — no la vas a poder alcanzar, por eso
  el paso 7 pide setear `DB_HOST` explícito en `.env`.
- Hay 3 archivos de vendor (`bootstrap.bundle.js`, `bootstrap.min.js`,
  `bootstrap.bundle.min.js`) commiteados dentro de `resources/views/Recursos/js/` —
  no los toques, son de Bootstrap, no del proyecto.
