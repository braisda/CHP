SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- DATABASE: chp(CONTROL HORARIO PROFESORADO)
--
-- CREATES THE DATABASE DELETING IT IF IT ALREADY EXISTS
--
DROP DATABASE IF EXISTS `chp_test`;
CREATE DATABASE `chp_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
--
-- SELECTS FOR USE
--
USE `chp_test`;

--
-- GIVES PERMISSION OF USE AND DELETES THE usuario THAT WE WANT TO CREATE FOR THERE IS
--
GRANT USAGE ON * . * TO `userCHP`@`localhost`;
	DROP USER `userCHP`@`localhost`;
--
-- CREATES THE usuario AND GIVES YOU PASSWORD - GIVES PERMIT OF USE AND GIVES PERMITS ON THE DATABASE
--
CREATE USER IF NOT EXISTS `userCHP`@`localhost` IDENTIFIED BY 'passCHP';
GRANT USAGE ON *.* TO `userCHP`@`localhost`;
GRANT ALL PRIVILEGES ON `chp_test`.* TO `userCHP`@`localhost` WITH GRANT OPTION;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `usuario`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `usuario` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `dni` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `direccion` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `telefono` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`login`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `ROLE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `rol` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `descripcion` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `usuario_GROUP`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `usuario_rol` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idusuario` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `idrol` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`idusuario`)
	REFERENCES `usuario`(`login`),
  FOREIGN KEY (`idrol`)
	REFERENCES `rol`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `usuario_rol` ADD UNIQUE KEY `uidx` (`idusuario`, `idrol`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `FUNCTIONALITY`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `funcionalidad` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `accion`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `accion` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `funcaccion`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `funcaccion` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idfuncionalidad` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `idaccion` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`idfuncionalidad`)
	REFERENCES `funcionalidad`(`id`),
  FOREIGN KEY (`idaccion`)
	REFERENCES `accion`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `funcaccion` ADD UNIQUE KEY `uidx` (`idfuncionalidad`, `idaccion`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `PERMISSION`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `permiso` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idrol` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `idfuncaccion` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`idrol`)
	REFERENCES `rol`(`id`),
  FOREIGN KEY (`idfuncaccion`)
	REFERENCES `funcaccion`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `permiso` ADD UNIQUE KEY `uidx` (`idrol`, `idfuncaccion`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `ACADEMIC_curso`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `curso_academico` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `nombre` varchar(6) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `anoinicio` int(4) COLLATE latin1_spanish_ci NOT NULL,
  `anofin` int(4) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `universidad`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `universidad` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idcursoacademico` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `idusuario` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `idcursoacademico`),
  FOREIGN KEY (`idcursoacademico`)
	REFERENCES `curso_academico`(`id`),
  FOREIGN KEY (`idusuario`)
    REFERENCES `usuario`(`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `universidad` ADD UNIQUE KEY `uidx` (`idcursoacademico`, `nombre`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `edificio`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `edificio` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `localizacion` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `idusuario` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`idusuario`)
    REFERENCES `usuario`(`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `edificio` ADD UNIQUE KEY `uidx` (`localizacion`, `nombre`, `idusuario`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `centro`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `centro` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `iduniversidad` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `idedificio` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `idusuario` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`iduniversidad`)
	REFERENCES `universidad`(`id`),
  FOREIGN KEY (`idusuario`)
    REFERENCES `usuario`(`login`),
  FOREIGN KEY (`idedificio`)
    REFERENCES `edificio`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `centro` ADD UNIQUE KEY `uidx` (`iduniversidad`, `nombre`, `idusuario`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `espacio`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `espacio` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idedificio` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `capacidad` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `oficina` tinyint(1) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `idedificio`),
  FOREIGN KEY (`idedificio`)
	REFERENCES `edificio`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
ALTER TABLE `espacio` ADD UNIQUE KEY `uidx` (`idedificio`, `nombre`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `grado`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `grado` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `idcentro` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `capacidad` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `creditos` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `idusuario` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `idcentro`),
  FOREIGN KEY (`idcentro`)
	REFERENCES `centro`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `profesor`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `profesor` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idusuario` varchar(9) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `idespacio` int(8) COLLATE latin1_spanish_ci,
  `dedicacion` varchar(4) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`idespacio`)
	REFERENCES `espacio`(`id`),
  FOREIGN KEY (`idusuario`)
	REFERENCES `usuario`(`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `departamento`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `departamento` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `codigo` varchar(7) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `idprofesor` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`idprofesor`)
	REFERENCES `profesor`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `materia`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `materia` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `contenido` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `tipo` varchar(2) COLLATE latin1_spanish_ci NOT NULL,
  `iddepartamento` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `area` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `curso` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `cuatrimestre` varchar(3) COLLATE latin1_spanish_ci NOT NULL,
  `creditos` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `nuevoregistro` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `repeticiones` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `estudiantesefectivos` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `horasinscritas` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  `horasenseño` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `horas` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `alumnos` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `idgrado` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `idprofesor` int(8) COLLATE latin1_spanish_ci NULL,
  `acronimo` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`idgrado`)
	REFERENCES `grado`(`id`),
  FOREIGN KEY (`iddepartamento`)
    REFERENCES `departamento`(`id`),
  FOREIGN KEY (`idprofesor`)
    REFERENCES `profesor`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `grupo_materia`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `grupo_materia` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idmateria` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `idmateria`),
  FOREIGN KEY (`idmateria`)
	REFERENCES `materia`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `tutoria`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `tutoria` (
  `idtutoria` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idprofesor` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `fechainicio` datetime COLLATE latin1_spanish_ci NOT NULL,
  `fechafin` datetime COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`idtutoria`, `idprofesor`),
  FOREIGN KEY (`idprofesor`)
	REFERENCES `profesor`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `horario`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `horario` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idespacio` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `idprofesor` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `idgrupomateria` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `horainicio` time COLLATE latin1_spanish_ci NOT NULL,
  `horafin` time COLLATE latin1_spanish_ci NOT NULL,
  `dia` date COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `idespacio`, `idprofesor`, `idgrupomateria`),
  FOREIGN KEY (`idespacio`)
	REFERENCES `espacio`(`id`),
  FOREIGN KEY (`idprofesor`)
	REFERENCES `profesor`(`id`),
  FOREIGN KEY (`idgrupomateria`)
	REFERENCES `grupo_materia`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `materia_profesor`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `materia_profesor` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `idmateria` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `idprofesor` int(8) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `horas` int(2) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`idmateria`)
	REFERENCES `materia`(`id`),
  FOREIGN KEY (`idprofesor`)
	REFERENCES `profesor`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `asistencia`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `asistencia` (
    `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
    `idmateria` int(8) COLLATE latin1_spanish_ci NOT NULL,
    `numalumnos` int(3) DEFAULT 0 COLLATE latin1_spanish_ci NOT NULL,
    `asiste` tinyint(1) DEFAULT 0 COLLATE latin1_spanish_ci NOT NULL,
    `idhorario` int(8) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
    PRIMARY KEY(`id`),
    FOREIGN KEY (`idmateria`)
	    REFERENCES `grupo_materia`(`id`),
	FOREIGN KEY (`idhorario`)
    	    REFERENCES `horario`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;