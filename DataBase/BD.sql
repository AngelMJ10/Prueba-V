CREATE DATABASE vamas;

USE vamas;

--------------------------------------

CREATE TABLE tipoDocumento(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

INSERT INTO tipoDocumento(datos)VALUES('{"nombre": "DNI", "estado": "1"}');

INSERT INTO tipoDocumento(datos)VALUES('{"nombre": "RUC", "estado": "1"}');

INSERT INTO tipoDocumento(datos)VALUES('{"nombre": "Pasaporte", "estado": "1"}');
SELECT * FROM tipodocumento;

-------------------------------------------------------

CREATE TABLE persona(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

 SELECT * FROM persona WHERE (JSON_EXTRACT (datos,'$.documento') = 72745028);
-----------------------------------------

CREATE TABLE usuario(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

SELECT * FROM usuario;

SELECT id,datos FROM usuario WHERE(JSON_EXTRACT (datos,'$.correo') = 'angelitomasna200410@gmail.com');

-----------------------------------------


CREATE TABLE empresa(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

SELECT * FROM empresa;

--------------------------------------

CREATE TABLE cliente(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

SELECT * FROM cliente;

---------------------------------------

CREATE TABLE proyecto(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

SELECT * FROM proyecto;

------------------------------------------

CREATE TABLE equipo(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

SELECT * FROM equipo;

--------------------------------------

