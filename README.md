# Sistema de Login y Recuperación de Contraseña
Este proyecto es un sistema de autenticación de usuarios que permite el registro, login, y restablecimiento de contraseña mediante el envío de un código de verificación por correo electrónico. Está desarrollado utilizando PHP, MySQL, PHPMailer y otros componentes de soporte para la gestión de usuarios.

## Características
- **Registro de usuario:** Los usuarios pueden crear una cuenta proporcionando su nombre, correo electrónico y contraseña.
- **Inicio de sesión:** Los usuarios registrados pueden iniciar sesión con su correo electrónico y contraseña.
- **Recuperación de contraseña:** Si un usuario olvida su contraseña, puede solicitar un código de verificación que se envía a su correo electrónico para restablecer su contraseña.
- **Verificación por correo electrónico:** El código de verificación es enviado a través de correo electrónico utilizando el servicio SMTP.
- **Base de datos MySQL:** El sistema almacena los datos de usuarios, como nombres, correos electrónicos, contraseñas y los tokens de recuperación.

## Estructura del Proyecto
- **HTML y CSS:** La interfaz de usuario está diseñada utilizando HTML5 y CSS3. Los formularios de login, registro, y restablecimiento de contraseña están estilizados con un diseño básico.
- **PHP:** Los formularios son procesados por scripts PHP que manejan la lógica de autenticación, registro y restablecimiento de contraseñas.
- **PHPMailer:** Librería usada para enviar correos electrónicos con el código de verificación necesario para restablecer la contraseña.
- **MySQL:** Base de datos donde se almacenan los datos de usuarios, incluidos los tokens para el restablecimiento de contraseña.


## Instalación

## Requisitos Previos
-   XAMPP o cualquier servidor que soporte PHP y MySQL.
- Composer para instalar PHPMailer.
- Servidor SMTP para el envío de correos electrónicos (en este caso, Gmail).


## Pasos para la instalación
1. **Clona el repositorio o descarga los archivos.**
2. **Configura la base de datos:**
    - **Importa el archivo SQL para crear las tablas necesarias:**
        - **usuarios** (id, name, birthday, username, password)
        - **password_resets** (id, email, token, expira)
        - **BASE DE DATOS:** 
        drop DATABASE ECOLLI_DB;
        CREATE DATABASE IF NOT EXISTS ECOLLI_DB;
        USE ECOLLI_DB;
        CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            birthday DATE NOT NULL,
            username VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );

        CREATE TABLE password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            token VARCHAR(100) NOT NULL,
            expira DATETIME NOT NULL
        );

3. **Configura los archivos PHP:**
    - Ajusta las credenciales de tu base de datos en conexion.php.
    - Modifica las configuraciones de PHPMailer en los scripts relacionados con el envío de correos (ej. servidor SMTP, usuario, y contraseña).
4. **Instala composer**
    - Ir a: https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwjc7Ijb-4GJAxUwSTABHReEJiMQmuEJegQIDxAB&url=https%3A%2F%2Fgetcomposer.org%2Fdownload%2F&usg=AOvVaw0hifbxuQZySOtGjSzPWfJo&opi=89978449
5. **Instala PHPMailer:**
    - Situate en la carpeta C:\xampp\htdocs\tu_proyecto\
    - Ejecuta "composer require phpmailer/phpmailer" para instalar la librería de PHPMailer en powershell.    
6. **Configura tu servidor SMTP:**
    - Usa un servidor SMTP como Gmail (utilizar un token de autenticación). 
    - tutorial usado: https://youtu.be/oPAo8Hh8bj0?list=LL


## Funcionalidades Clave

## Registro de Usuario
- Los usuarios se registran a través de un formulario que solicita correo electrónico, nombre y contraseña.
- La contraseña se guarda en la base de datos después de ser hasheada para mayor seguridad.

## Inicio de Sesión
- Los usuarios inician sesión con su correo electrónico y contraseña.
- Se verifica si la combinación es correcta antes de permitir el acceso.}

## Recuperación de Contraseña
- El usuario ingresa su correo electrónico en la página de "Olvidé mi contraseña".
- Se genera un código aleatorio de 6 dígitos que se envía al correo proporcionado.
- El usuario ingresa el código en la página de verificación, lo que le permite restablecer su contraseña.


## Archivos Clave
- index.html: Página de inicio de sesión.
- registro.html: Página de registro de usuarios.
- olvido_password.html: Página donde el usuario solicita la recuperación de su contraseña.
- verificar_codigo.html: Página para introducir el código de verificación enviado por correo.
- restablecer_password.html: Página para restablecer la contraseña.
- conexion.php: Conexión a la base de datos.
- enviar_codigo.php: Script para generar y enviar el código de verificación.
- verificar_codigo.php: Verifica el código de verificación ingresado.
- restablecer_password.php: Procesa el restablecimiento de la contraseña.
- Tecnologías Utilizadas
- Frontend: HTML5, CSS3.
- Backend: PHP.
- Base de Datos: MySQL.
- Email: PHPMailer (con SMTP de Gmail).
- Servidor local: XAMPP (Apache, MySQL, PHP).

## Contribuciones
Las contribuciones son bienvenidas. Por favor, abre un "issue" para discutir cualquier cambio o mejora que quieras implementar.

## Licencia
Este proyecto está bajo la licencia MIT.