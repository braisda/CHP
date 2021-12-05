SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- DATABASE: chp(CONTROL HORARIO PROFESORADO)
--
-- CREATES THE DATABASE DELETING IT IF IT ALREADY EXISTS
--
DROP DATABASE IF EXISTS `chp`;
CREATE DATABASE `chp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
--
-- SELECTS FOR USE
--
USE `chp`;

--
-- GIVES PERMISSION OF USE AND DELETES THE usuario THAT WE WANT TO CREATE FOR THERE IS
--
GRANT USAGE ON * . * TO `usuarioCHP`@`localhost`;
	DROP USER `usuarioCHP`@`localhost`;
--
-- CREATES THE usuario AND GIVES YOU PASSWORD - GIVES PERMIT OF USE AND GIVES PERMITS ON THE DATABASE
--
CREATE USER IF NOT EXISTS `usuarioCHP`@`localhost` IDENTIFIED BY 'passCHP';
GRANT USAGE ON *.* TO `usuarioCHP`@`localhost`;
GRANT ALL PRIVILEGES ON `chp`.* TO `usuarioCHP`@`localhost` WITH GRANT OPTION;
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
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
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
  `oficina` bit COLLATE latin1_spanish_ci NOT NULL,
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
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
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
  `codigo` varchar(6) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
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
  `idprofesor` int(8) COLLATE latin1_spanish_ci NOT NULL,
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
  `fechaInicio` datetime COLLATE latin1_spanish_ci NOT NULL,
  `fechaFin` datetime COLLATE latin1_spanish_ci NOT NULL,
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
  `idhorario` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `idespacio` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `idprofesor` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `idgrupomateria` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`idhorario`, `idespacio`, `idprofesor`, `idgrupomateria`),
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

INSERT INTO `accion` (`id`, `nombre`, `descripcion`) VALUES
('1', 'ADD', 'ADD'),
('2', 'DELETE', 'DELETE'),
('3', 'EDIT', 'EDIT'),
('4', 'SHOWCURRENT', 'SHOWCURRENT'),
('5', 'SHOWALL', 'SHOWALL');

INSERT INTO `funcionalidad` (`id`, `nombre`, `descripcion`) VALUES
('1', 'usuarioManagement', 'usuarioManagement'),
('2', 'RoleManagement', 'RoleManagement'),
('3', 'FunctionalityManagement', 'FunctionalityManagement'),
('4', 'accionManagement', 'accionManagement'),
('5', 'PermissionManagement', 'PermissionManagement'),
('6', 'AcademiccursoManagement', 'AcademiccursoManagement'),
('7', 'FuncaccionManagement', 'FuncaccionManagement'),
('8', 'usuarioRoleManagement', 'usuarioRoleManagement'),
('9', 'universidadManagement', 'universidadManagement'),
('10', 'centroManagement', 'centroManagement'),
('11', 'edificioManagement', 'edificioManagement'),
('12', 'espacioManagement', 'espacioManagement'),
('13', 'gradoManagement', 'gradoManagement'),
('14', 'departamentoManagement', 'departamentoManagement'),
('15', 'profesorManagement', 'profesorManagement'),
('16', 'materiaManagement', 'materiaManagement'),
('17', 'materiaprofesorManagement', 'materiaprofesorManagement');



INSERT INTO `funcaccion` (`id`,`idfuncionalidad`, `idaccion`) VALUES
('1','1','1'),
('2','1','2'),
('3','1','3'),
('4','1','4'),
('5','1','5'),
('6','2','1'),
('7','2','2'),
('8','2','3'),
('9','2','4'),
('10','2','5'),
('11','3','1'),
('12','3','2'),
('13','3','3'),
('14','3','4'),
('15','3','5'),
('16','4','1'),
('17','4','2'),
('18','4','3'),
('19','4','4'),
('20','4','5'),
('21','5','1'),
('22','5','2'),
('23','5','3'),
('24','5','4'),
('25','5','5'),
('26','6','1'),
('27','6','2'),
('28','6','3'),
('29','6','4'),
('30','6','5'),
('31','7','1'),
('32','7','2'),
('33','7','3'),
('34','7','4'),
('35','7','5'),
('36','8','1'),
('37','8','2'),
('38','8','3'),
('39','8','4'),
('40','8','5'),
('41','9','1'),
('42','9','2'),
('43','9','3'),
('44','9','4'),
('45','9','5'),
('46','10','1'),
('47','10','2'),
('48','10','3'),
('49','10','4'),
('50','10','5'),
('51','11','1'),
('52','11','2'),
('53','11','3'),
('54','11','4'),
('55','11','5'),
('56','12','1'),
('57','12','2'),
('58','12','3'),
('59','12','4'),
('60','12','5'),
('61','13','1'),
('62','13','2'),
('63','13','3'),
('64','13','4'),
('65','13','5'),
('66','14','1'),
('67','14','2'),
('68','14','3'),
('69','14','4'),
('70','14','5'),
('71','15','1'),
('72','15','2'),
('73','15','3'),
('74','15','4'),
('75','15','5'),
('76','16','1'),
('77','16','2'),
('78','16','3'),
('79','16','4'),
('80','16','5'),
('81','17','1'),
('82','17','2'),
('83','17','3'),
('84','17','4'),
('85','17','5');

INSERT INTO `usuario` (`login`,`password`,`dni`, `nombre`,`apellido`,`email`,`direccion`,`telefono`) VALUES
('admin','21232f297a57a5a743894a0e4a801fc3' , '11122233P','Administrador','Administrador', 'admin@admin.com', 'address', '666555444'),
('gestuniv','21232f297a57a5a743894a0e4a801fc3' , '11122233P','GestUniv','GestUniv', 'GestUniv@GestUniv.com', 'address', '666555444'),
('gestcent','21232f297a57a5a743894a0e4a801fc3' , '11122233P','GestCent','GestCent', 'GestCent@GestCent.com', 'address', '666555444'),
('gestbuil','21232f297a57a5a743894a0e4a801fc3' , '11122233P','GestBuil','GestBuil', 'GestBuil@GestBuil.com', 'address', '666555444'),
('gestdeg','21232f297a57a5a743894a0e4a801fc3' , '11122233P','Gestgrado','Gestgrado', 'Gestgrado@Gestgrado.com', 'address', '666555444');

INSERT INTO `rol` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Admin', 'Role with all permissions'),
(2, 'GestUniv', 'Role with universidad Owner permissions'),
(3, 'GestCent', 'Role with centro Owner permissions'),
(4, 'GestBuil', 'Role with edificio Owner permissions'),
(5, 'Gestgrado', 'Role with grado Owner permissions'),
(6, 'Basicusuario', 'Role with the basic permissions'),
(7, 'Test', 'Role to test');

INSERT INTO `usuario_rol` (`idusuario`,`idrol`) VALUES
('admin', 1),
('gestuniv', 2),
('gestcent', 3),
('gestbuil', 4),
('gestdeg', 5);

INSERT INTO `permiso` (`idrol`,`idfuncaccion`) VALUES
(1,'1'),
(1,'2'),
(1,'3'),
(1,'4'),
(1,'5'),
(1,'6'),
(1,'7'),
(1,'8'),
(1,'9'),
(1,'10'),
(1,'11'),
(1,'12'),
(1,'13'),
(1,'14'),
(1,'15'),
(1,'16'),
(1,'17'),
(1,'18'),
(1,'19'),
(1,'20'),
(1,'21'),
(1,'22'),
(1,'23'),
(1,'24'),
(1,'25'),
(1,'26'),
(1,'27'),
(1,'28'),
(1,'29'),
(1,'30'),
(1,'31'),
(1,'32'),
(1,'33'),
(1,'34'),
(1,'35'),
(1,'36'),
(1,'37'),
(1,'38'),
(1,'39'),
(1,'40'),
(1,'41'),
(1,'42'),
(1,'43'),
(1,'44'),
(1,'45'),
(1,'46'),
(1,'47'),
(1,'48'),
(1,'49'),
(1,'50'),
(1,'51'),
(1,'52'),
(1,'53'),
(1,'54'),
(1,'55'),
(1,'56'),
(1,'57'),
(1,'58'),
(1,'59'),
(1,'60'),
(1,'61'),
(1,'62'),
(1,'63'),
(1,'64'),
(1,'65'),
(1,'66'),
(1,'67'),
(1,'68'),
(1,'69'),
(1,'70'),
(1,'71'),
(1,'72'),
(1,'73'),
(1,'74'),
(1,'75'),
(1,'76'),
(1,'77'),
(1,'78'),
(1,'79'),
(1,'80'),
(1,'81'),
(1,'82'),
(1,'83'),
(1,'84'),
(1,'85'),
(2,'46'),
(2,'47'),
(2,'48'),
(2,'49'),
(2,'50'),
(2,'43'),
(2,'44'),
(2,'45'),
(2,'51'),
(2,'54'),
(2,'55'),
(3,'49'),
(3,'50'),
(3,'61'),
(3,'62'),
(3,'63'),
(3,'64'),
(3,'65'),
(4,'52'),
(4,'53'),
(4,'54'),
(4,'55'),
(5,'64'),
(5,'65');

INSERT INTO `curso_academico` (`id`, `nombre`, `anoinicio`, `anofin`) VALUES
(1, '18/19', '2018', '2019'),
(2, '19/20', '2019', '2020'),
(3, '20/21', '2020', '2021'),
(4, '21/22', '2021', '2022'),
(5, '22/23', '2022', '2023');