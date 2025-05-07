# Lechuga Negra - AuthManager para Laravel

Este paquete de Laravel proporciona un sistema de autenticación completo y robusto para tus aplicaciones, simplificando la gestión de usuarios, el inicio y cierre de sesión, la generación y refresco de tokens JWT, y la validación de reCAPTCHA.

## Características Principales

* **Autenticación JWT:** Utiliza JSON Web Tokens (JWT) para una autenticación segura y sin estado.
* **Inicio de Sesión:** Proceso de inicio de sesión completo con generación de tokens JWT.
* **Datos de Usuario Logueado:** Obtén información del usuario autenticado fácilmente.
* **Cierre de Sesión:** Invalida los tokens JWT para cerrar la sesión del usuario.
* **Refresco de Sesión:** Genera nuevos tokens JWT para mantener la sesión activa.
* **Validación de reCAPTCHA:** Integración con reCAPTCHA para proteger contra ataques de fuerza bruta.
* **Middleware de Autenticación:** Middleware para proteger rutas y asegurar que solo usuarios autenticados puedan acceder.
* **Endpoint de validación de token:** Endpoint para validar token de autenticación, su objetivo es para uso de microservicio.

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
    cd lechuganegra
    ```

2.  **Clonar el paquete:**

    Clonar el paquete en el grupo de carpetas creado y renombrarlo para que el Provider pueda registrarlo en la instalación

    ```bash
    git clone https://github.com/mtorres-lechuganegra/package-authmanager.git authmanager
    ```

3.  **Configurar composer del proyecto:**

    Dirígite a la raíz de tu proyecto, edita tu archivo `composer.json` y añade el paquete como repositorio:

    ```json
    {
        "repositories": [
            {
                "type": "path",
                "url": "packages/lechuganegra/authmanager"
            }
        ]
    }
    ```
    también deberás añadir el namespace del paquete al autoloading de PSR-4:

    ```json
    {
        "autoload": {
            "psr-4": {
                "LechugaNegra\\AuthManager\\": "packages/lechugaNegra/authmanager/src/"
            }
        }
    }
    ```

4.  **Ejecutar composer require:**

    Después de editar tu archivo, abre tu terminal y ejecuta el siguiente comando para agregar el paquete a las dependencias de tu proyecto:

    ```bash
    composer require lechuganegra/authmanager:@dev
    ```

    Este comando descargará el paquete y actualizará tu archivo `composer.json`.

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

    Edita el archivo `config/auth.php` y agrega `api` en el guard para utilizar JWT:

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
    
10.  **Regenerar clases:**

    Regenerar las clases con el cargador automático "autoload"

    ```bash
    composer dump-autoload
    ```

## Uso

### Endpoints del Servicio

Puede importar el archivo `postman_collection.json` que se ubica en la carpeta `docs` de la raíz del paquete.

### Middleware de Autenticación

Para proteger tus rutas con el middleware de autenticación, utiliza `auth:api` y `guard:api`:

```php
Route::middleware(['auth:api', 'guard:api'])->group(function () {
    // Rutas protegidas
});
```

### reCaptcha

Para poder usar el endpoint de `login` con validación de reCaptcha, deberás agregar las credenciales en tu archivo .env:

```nginx
RECAPTCHA_ENABLED=true
RECAPTCHA_SECRET_KEY=tu_secret_key_aqui
```
