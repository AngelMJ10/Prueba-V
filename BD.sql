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

SELECT JSON_EXTRACT(datos , '$.nombre') FROM tipoDocumento WHERE id = 1 AND JSON_EXTRACT(datos, '$.estado') =  1;

-------------------------------------------------------

CREATE TABLE persona(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

INSERT INTO persona(datos) 
VALUES('{"apellidos": "Marquina Jaime", "nombre": "Ángel Eduardo", "idTipoDocumento": "1" , "documento" : "72745028",
	"fechaNacimiento" : "2004/07/10","telefono" : 951531166,"estado" : "1"}');
	
 SELECT * FROM persona WHERE (JSON_EXTRACT (datos,'$.documento') = 72745028);
 TRUNCATE TABLE persona;
-----------------------------------------

CREATE TABLE usuario(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

INSERT INTO usuario(datos)
VALUES('{"idPersona" : "1","correo" : "angelitomasna200410@gmail.com", "clave" : "SENATI",
	"fecha" : "2023-05-18", "user" : "angelm", "hora" : "10:47:45",
	"direccion" : "León de vivero MZ V LT-22","cargo" : "A","idPersona" : "1", "equipo" : "0", "estado" : "1"}');

SELECT id,datos FROM usuario WHERE id = 1;

SELECT id,datos FROM usuario WHERE(JSON_EXTRACT (datos,'$.correo') = 'angelitomasna200410@gmail.com');

INSERT INTO usuario(datos) 
VALUES('{"idPersona" : "1","correo" : "angelitomasna200410@gmail.com", "clave" : "SENATI" , "cargo" : "E" , "direccion" : "Pueblo Nuevo"}');

SELECT * FROM usuario;

TRUNCATE TABLE usuario;

-----------------------------------------


CREATE TABLE empresa(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

INSERT INTO empresa(datos) 
VALUES ('{"nombre" : "Vamas S.A.C." , "idTipoDocumento" : "2" , "documento" : "20609878313" ,
	"idPais" : "1" , "nombreComercial" : "Vamas" ,"estado" : "1" , "fechaRegistro" : "2023-05-18" 
	, "hora" : "09:04:45"}');

SELECT * FROM empresa;
TRUNCATE TABLE empresa;

---------------------------------------

CREATE TABLE equipo(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

INSERT INTO equipo(datos) 
VALUES('{"nombre" : "Front-End" ,"integrantes" : [{"idPersona" : "1" , "idUsuario" : "1", "idIntegrante" : "1", "disponible" : "1"},{"idPersona" : "2" , "idUsuario" : "2", "idIntegrante" : "2", "disponible" : "1"} ,{"idPersona" : "3" , "idUsuario" : "3", "idIntegrante" : "3", "disponible" : "1"}],"fechaRegistro" : "2023-05-21" , "hora" : "2:00:00" , "estado" : "1"}');
INSERT INTO equipo(datos) 
VALUES('{"nombre" : "Front-End" ,"integrantes" : [] ,"fechaRegistro" : "2023-05-21" , "hora" : "18:11:45" , "estado" : "1"}');
SELECT * FROM equipo WHERE id =1;

UPDATE equipo
SET datos = JSON_ARRAY_APPEND(datos, '$.integrantes', JSON_OBJECT(
    'idUsuario', '3',
    'idIntegrante', '4',
    'disponible', '1'
))
WHERE id = 2;

TRUNCATE TABLE equipo;

UPDATE equipo SET datos = JSON_SET(datos , '$.integrantes', JSON_REMOVE(JSON_EXTRACT(datos, '$.integrantes'), '$[1]')) WHERE id =1;

-- Para remover un integrante

UPDATE equipo SET datos = JSON_SET(datos , '$.integrantes', JSON_REMOVE(JSON_EXTRACT(datos, '$.integrantes'), '$[0]')) WHERE id =2;

UPDATE equipo SET datos = JSON_SET(datos , '$.integrantes', JSON_REMOVE(JSON_EXTRACT(datos, '$.integrantes'), '$[?]')) WHERE id =1;
-- Para contar los integrantes
SELECT JSON_LENGTH(datos,'$.integrantes') AS Cantidad FROM equipo WHERE id =1 ;

-- Para obtener el integrante
SELECT JSON_EXTRACT(datos,'$.integrantes[0]') AS Integrante FROM equipo WHERE id = 1;

-- Para actualizar a los usuario y que	
UPDATE usuario SET datos = JSON_SET(datos , '$.equipo' , 0) WHERE id =4;
SELECT JSON_EXTRACT(datos, '$.integrantes') FROM equipo WHERE id = 1
SELECT * FROM usuario WHERE JSON_EXTRACT(datos , '$.equipo') = 0;

UPDATE equipo SET datos = JSON_SET(datos,'$[0]' , "fechaEntrada : 24-05-2023") WHERE id=1;

UPDATE equipo SET datos = JSON_SET(datos, '$.integrantes[0].fechaSalida', "24-05-2023") WHERE id = 1;

UPDATE equipo SET datos = JSON_SET(datos, '$.integrantes[0].idIntegrante', 1) WHERE id = 2;

SELECT  JSON_EXTRACT(datos, '$.integrantes[0].idUsuario') FROM equipo WHERE id= 1;

SELECT * FROM equipo;

----------------------------------------

CREATE TABLE proyecto(
id INT PRIMARY KEY AUTO_INCREMENT,
datos JSON NULL
)ENGINE = MYISAM

------------------------------------------
