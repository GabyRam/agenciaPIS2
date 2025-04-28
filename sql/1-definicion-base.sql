-- Eliminar la base de datos si existe
DROP DATABASE IF EXISTS agencia_autos;

-- Crear usuario 'agencia_admin' si no existe
DO $$
BEGIN
    IF NOT EXISTS (SELECT FROM pg_catalog.pg_roles WHERE rolname = 'agencia_admin') THEN
        CREATE ROLE agencia_admin LOGIN PASSWORD 'admin' CREATEDB;
    END IF;
END
$$;

-- Crear base de datos 'agencia_autos'
CREATE DATABASE agencia_autos
WITH OWNER = agencia_admin
ENCODING = 'UTF8'
LC_COLLATE = 'en_US.UTF-8'
LC_CTYPE = 'en_US.UTF-8'
TEMPLATE = template0;

-- Conectarse a la base de datos
\connect agencia_autos;

-- Crear esquema 'app' si no existe
DO $$
BEGIN
    IF NOT EXISTS (SELECT FROM information_schema.schemata WHERE schema_name = 'app') THEN
        CREATE SCHEMA app AUTHORIZATION agencia_admin;
    END IF;
END
$$;