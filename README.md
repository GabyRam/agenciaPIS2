# 🚗 Agencia de Autos - Proyecto Web en PHP + PostgreSQL

Este proyecto es un sistema básico para gestionar una agencia de autos, desarrollado en PHP, utilizando PostgreSQL como base de datos.

---

## 📁 Estructura del Proyecto

- **app/**: Contiene la lógica del negocio, servicios y controladores.
- **public/**: Carpeta pública donde se encuentra el archivo `index.php` y otros recursos accesibles.
- **sql/**: Archivos SQL para la creación y definición de la base de datos y tablas.
- **config/**: Archivos de configuración, incluyendo las credenciales de la base de datos.

---

## ⚙️ Requisitos

- [PHP](https://www.php.net/) (versión 8.0 o superior)
- [PostgreSQL](https://www.postgresql.org/) instalado y corriendo
- [pgAdmin](https://www.pgadmin.org/) para gestionar la base de datos (opcional)
- [Composer](https://getcomposer.org/) para manejar dependencias de PHP (opcional, si es necesario)

---

## 🚀 Instrucciones para levantar el proyecto

1. Clona este repositorio o copia el contenido del proyecto.
   
2. **Instala PostgreSQL** y crea la base de datos `agencia_autos` y el usuario `agencia_admin`. Si no tienes PostgreSQL instalado, puedes hacerlo desde [aquí](https://www.postgresql.org/download/).

3. **Configura las credenciales en el archivo `config/config.php`**. Asegúrate de que el archivo tenga los siguientes valores:

   return [
       'host' => 'localhost',    // Cambia si usas otro host
       'dbname' => 'agencia_autos',
       'user' => 'agencia_admin',
       'password' => 'admin',  // Usa la contraseña correcta
   ];

4. **Crea la base de datos**. Abre una terminal de comandos y ejecuta los siguientes pasos:

   - Primero, crea la base de datos:

     psql -U postgres -f "D:/Documentos/UAM/PIS 2/agencia/sql/1-definicion-base.sql"

     Te pedirá la contraseña para el usuario `postgres`.

   - Luego, crea las tablas en la base de datos:

     psql -U agencia_admin -d agencia_autos -f "D:/Documentos/UAM/PIS 2/agencia/sql/2-definicion-tablas.sql"

     Te pedirá la contraseña para el usuario `agencia_admin`.

     Una vez completado, podrás ver las tablas creadas en tu pgAdmin.

5. **Instala las dependencias**. Si el proyecto utiliza Composer, ejecuta:

   composer install

6. **Levanta tu servidor PHP**. Abre una terminal y navega al directorio donde está tu proyecto. Luego, ejecuta el siguiente comando para iniciar el servidor embebido de PHP:

   php -S localhost:8000 -t public

7. **Abre tu navegador** en `http://localhost:8000`.

8. Deberías ver en pantalla: 🚀 **Conexión exitosa!**

---

## 🛠️ Problemas comunes

- Si al intentar acceder al servidor en el navegador no se carga la página, asegúrate de que **PostgreSQL** esté corriendo y que las credenciales sean correctas.
- Si obtienes un error relacionado con la conexión a la base de datos, revisa la configuración en `config/config.php`.

---

