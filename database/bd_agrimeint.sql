CREATE DATABASE IF NOT EXISTS  agrimeint;

USE agrimeint;


CREATE TABLE usuario(
id_usuario  INT(11) NOT NULL AUTO_INCREMENT,
nombre  VARCHAR(60) NOT NULL,
apellidos  VARCHAR(60)  NOT NULL,
email  VARCHAR(40) NOT NULL,
telefono  VARCHAR(30) NOT NULL,
PASSWORD  VARCHAR(50) NOT NULL,
nivel  VARCHAR(25),
fecha_registro  DATE,
foto  BLOB,
CONSTRAINT pk_usuario PRIMARY KEY(id_usuario),
CONSTRAINT uq_email UNIQUE(email)
)ENGINE=INNODB;



CREATE TABLE categoria(
id_categoria  INT(11) NOT NULL AUTO_INCREMENT,
nombre  VARCHAR(100),
CONSTRAINT pk_categoria PRIMARY KEY(id_categoria)
)ENGINE=INNODB;



CREATE TABLE publicacion(
id_publicacion  INT(11) NOT NULL AUTO_INCREMENT,
id_usuario  INT(11) NOT NULL,
id_categoria  INT(11) NOT NULL,
titulo  VARCHAR(255),
precio FLOAT(10,2),
descripcion TEXT,
estado  VARCHAR(100),
municipio VARCHAR(100),
fecha_publicacion  DATE,
CONSTRAINT pk_publicacion PRIMARY KEY(id_publicacion),
CONSTRAINT fk_publicacion_usuario FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario),
CONSTRAINT fk_publicacion_categoria FOREIGN KEY(id_categoria) REFERENCES categoria(id_categoria)
)ENGINE=InnoDB;
