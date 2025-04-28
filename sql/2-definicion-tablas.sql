-- Conectarse a la base de datos
\c agencia_autos;

-- Crear esquema si se desea usar uno específico
-- CREATE SCHEMA agencia AUTHORIZATION agencia_admin;
-- SET search_path TO agencia;
SET search_path TO app;


-- Definición de tablas
CREATE TABLE IF NOT EXISTS Personas (
    ID_Persona SERIAL PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Apellido_Paterno VARCHAR(100) NOT NULL,
    Apellido_Materno VARCHAR(100),
    Direccion TEXT,
    Telefono VARCHAR(20)
);
ALTER TABLE Personas OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Puesto (
    ID_Puesto SERIAL PRIMARY KEY,
    Puesto VARCHAR(100) NOT NULL,
    Sueldo NUMERIC(10,2) NOT NULL
);
ALTER TABLE Puesto OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Trabajadores (
    ID_Trabajador SERIAL PRIMARY KEY,
    ID_Persona INT REFERENCES Personas(ID_Persona) ON DELETE CASCADE,
    ID_Puesto INT REFERENCES Puesto(ID_Puesto)
);
ALTER TABLE Trabajadores OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Clientes (
    ID_Cliente SERIAL PRIMARY KEY,
    ID_Persona INT REFERENCES Personas(ID_Persona) ON DELETE CASCADE
);
ALTER TABLE Clientes OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Pagos (
    ID_Pago SERIAL PRIMARY KEY,
    ID_Persona INT REFERENCES Personas(ID_Persona),
    Numero_Pago VARCHAR(50)
);
ALTER TABLE Pagos OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Facturas (
    ID_Factura SERIAL PRIMARY KEY,
    ID_Persona INT REFERENCES Personas(ID_Persona),
    Numero_Factura VARCHAR(50)
);
ALTER TABLE Facturas OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Auto (
    ID_Auto SERIAL PRIMARY KEY,
    Costo INT,
    Anio INT,
    Capacidad INT,
    Cilindros INT,
    Disponibilidad BOOLEAN DEFAULT TRUE,
    Apartado BOOLEAN DEFAULT FALSE,
    modelo VARCHAR(100) NOT NULL
);
ALTER TABLE Auto OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Inventario (
    ID_Inventario SERIAL PRIMARY KEY,
    ID_Carro INT REFERENCES Auto(ID_Auto),
    Color VARCHAR(50),
    Cantidad INT
);
ALTER TABLE Inventario OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Catalogo (
    ID_Catalogo SERIAL PRIMARY KEY,
    ID_Carro INT REFERENCES Auto(ID_Auto)
);
ALTER TABLE Catalogo OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Kit (
    ID_Kit SERIAL PRIMARY KEY,
    Numero_kit VARCHAR(20)
);
ALTER TABLE Kit OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Placas (
    ID_Placas SERIAL PRIMARY KEY,
    Placas VARCHAR(10)
);
ALTER TABLE Placas OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Seguros (
    ID_Seguros SERIAL PRIMARY KEY,
    Numero_Seguro VARCHAR(50)
);
ALTER TABLE Seguros OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Post_Venta (
    ID_Post_Venta SERIAL PRIMARY KEY,
    ID_Kit INT,
    ID_Placas VARCHAR(10),
    ID_Seguros INT,
    Post_Venta TEXT
);
ALTER TABLE Post_Venta OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Venta (
    ID_Venta SERIAL PRIMARY KEY,
    ID_Carro INT REFERENCES Auto(ID_Auto),
    ID_Post_Venta INT REFERENCES Post_Venta(ID_Post_Venta),
    ID_Persona INT REFERENCES Personas(ID_Persona),
    ID_Trabajador INT REFERENCES Trabajadores(ID_Trabajador),
    ID_Pago INT REFERENCES Pagos(ID_Pago)
);
ALTER TABLE Venta OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Comentarios (
    ID_Comentarios SERIAL PRIMARY KEY,
    ID_Persona INT REFERENCES Personas(ID_Persona),
    Comentario TEXT,
    Fecha DATE
);
ALTER TABLE Comentarios OWNER TO agencia_admin;

CREATE TABLE IF NOT EXISTS Contacto (
    ID_Contacto SERIAL PRIMARY KEY,
    ID_Trabajador INT REFERENCES Trabajadores(ID_Trabajador),
    ID_Cliente INT REFERENCES Clientes(ID_Cliente),
    ID_Carro INT REFERENCES Auto(ID_Auto)
);
ALTER TABLE Contacto OWNER TO agencia_admin;