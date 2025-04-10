# Lechuga Negra - AuthManager para Laravel 11

Este paquete de Laravel 11 proporciona un sistema de autenticación completo y robusto para tus aplicaciones, simplificando la gestión de usuarios, el inicio y cierre de sesión, la generación y refresco de tokens JWT, y la validación de reCAPTCHA.

## Características Principales

* **Autenticación JWT:** Utiliza JSON Web Tokens (JWT) para una autenticación segura y sin estado.
* **Inicio de Sesión:** Proceso de inicio de sesión completo con generación de tokens JWT.
* **Datos de Usuario Logueado:** Obtén información del usuario autenticado fácilmente.
* **Cierre de Sesión:** Invalida los tokens JWT para cerrar la sesión del usuario.
* **Refresco de Sesión:** Genera nuevos tokens JWT para mantener la sesión activa.
* **Validación de reCAPTCHA:** Integración con reCAPTCHA para proteger contra ataques de fuerza bruta.
* **Middleware de Autenticación:** Middleware para proteger rutas y asegurar que solo usuarios autenticados puedan acceder.

## Instalación

1.  **Crear grupo de paquetes:**

    Crear la carpeta packages en la raíz del proyecto e ingresar a la carpeta:

    ```bash
    mkdir packages
    cd packages
    ```

    Crear el grupo de carpetas dentro de la carpeta creada, e ingresar a l carpeta:
    
    ```bash
    mkdir lechuganegra
    cd packages
    ```

2.  **Clonar el paquete:**

    Clonar el paquete en el grupo de carpetas creado y renombrarlo para que el Provider pueda registrarlo en la instalación

    ```bash
    git clone https://github.com/mtorres-lechuganegra/package-authmanager.git authmanager
    ```

3.  **Requerir el paquete vía Composer:**

    Abre tu terminal y ejecuta el siguiente comando para agregar el paquete a las dependencias de tu proyecto:

    ```bash
    composer require lechuganegra/authmanager:@dev
    ```

    Este comando descargará el paquete y actualizará tu archivo `composer.json`.

4.  **Configurar el autoloading:**

    Edita tu archivo `composer.json` y añade el namespace del paquete al autoloading de PSR-4:

    ```json
    {
        "autoload": {
            "psr-4": {
                "App\\": "app/",
                "LechugaNegra\\AuthManager\\": "packages/lechuganegra/authmanager/"
            }
        }
    }
    ```

    Luego, ejecuta el siguiente comando para regenerar el autoloading:

    ```bash
    composer dump-autoload
    ```

    Este paso asegura que Laravel pueda encontrar las clases del paquete.

5.  **Generar la clave secreta de JWT:**

    Ejecuta el siguiente comando para generar la clave secreta que se utilizará para firmar los tokens JWT:

    ```bash
    php artisan jwt:secret
    ```

    Este comando agregará la clave secreta a tu archivo `.env`.

6.  **Publicar la configuración de JWT:**

    Publica el archivo de configuración de JWT para poder personalizarlo si es necesario:

    ```bash
    php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
    ```

7.  **Configurar el guard de autenticación:**

    Edita el archivo `config/auth.php` y configura el guard `api` para utilizar JWT:

    ```php
    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],
    ```

8.  **Implementar JWTSubject en el modelo de usuario:**

    Abre tu modelo de usuario (generalmente `app/Models/User.php`) y agrega la interfaz `JWTSubject` y las funciones necesarias:

    ```php
    use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class User extends Authenticatable implements JWTSubject
    {
        // ... otras propiedades y métodos del modelo

        public function getJWTIdentifier()
        {
            return $this->getKey();
        }

        public function getJWTCustomClaims()
        {
            return [];
        }
    }
    ```

9.  **Limpiar la caché:**

    Limpia la caché de configuración y rutas para asegurar que los cambios se apliquen correctamente:

    ```bash
    php artisan config:clear
    php artisan config:cache
    php artisan route:clear
    php artisan route:cache
    ```

## Uso

### Middleware de Autenticación

Para proteger tus rutas con el middleware de autenticación, utiliza `auth:api` y `guard:api`:

```php
Route::middleware(['auth:api', 'guard:api'])->group(function () {
    // Rutas protegidas
});