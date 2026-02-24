-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2026 a las 15:57:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `utacuarto1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id_cur` int(11) NOT NULL,
  `nom_cur` varchar(15) NOT NULL,
  `des_cur` varchar(20) NOT NULL,
  `tit_oto` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_cur`, `nom_cur`, `des_cur`, `tit_oto`) VALUES
(1, 'PRIMERO', 'ING. SISTEMAS', 'INGENIERO'),
(2, 'SEGUNDO', 'ING. SISTEMAS', 'INGENIERO'),
(3, 'TERCERO', 'ING. SISTEMAS', 'INGENIERO'),
(5, 'SEGUNDO', 'DERECHO', 'ABOGADO'),
(6, 'PRIMERO', 'ENFERMERIA', 'LICENCIADO'),
(8, 'CUARTO', 'ING. SISTEMAS', 'INGENIERO'),
(9, 'PRIMERO', 'DERECHO', 'LICENCIADO');

--
-- Disparadores `cursos`
--
DELIMITER $$
CREATE TRIGGER `EVITAR_BORRAR_CURSO_CON_ALUMNOS` BEFORE DELETE ON `cursos` FOR EACH ROW BEGIN
    DECLARE NUM_ESTUDIANTES INT;
    SELECT COUNT(*) INTO NUM_ESTUDIANTES FROM MATRICULAS WHERE ID_CUR_PER = OLD.ID_CUR;
    IF NUM_ESTUDIANTES > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'NO SE PUEDE ELIMINAR PORQUE EXISTEN ESTUDIANTES EN ESTE CURSO';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EVITAR_DUPLICADO_CURSO_CARRERA` BEFORE INSERT ON `cursos` FOR EACH ROW BEGIN
    DECLARE EXISTE_COMBINACION INT;
    SELECT COUNT(*) INTO EXISTE_COMBINACION FROM CURSOS WHERE NOM_CUR = NEW.NOM_CUR AND DES_CUR = NEW.DES_CUR;
    IF EXISTE_COMBINACION > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'ERROR: YA EXISTE ESTE CURSO PARA ESA CARRERA';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EVITAR_DUPLICADO_CURSO_UPDATE` BEFORE UPDATE ON `cursos` FOR EACH ROW BEGIN
    DECLARE EXISTE_COMBINACION INT;
    SELECT COUNT(*) INTO EXISTE_COMBINACION FROM CURSOS WHERE NOM_CUR = NEW.NOM_CUR AND DES_CUR = NEW.DES_CUR AND ID_CUR <> OLD.ID_CUR; 
    IF EXISTE_COMBINACION > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'ERROR: AL ACTUALIZAR, COINCIDEN LOS DATOS CON OTRO CURSO YA EXISTENTE.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `estcedula` varchar(10) NOT NULL,
  `estnombre` varchar(15) NOT NULL,
  `estapellido` varchar(15) NOT NULL,
  `estdireccion` varchar(50) DEFAULT NULL,
  `esttelefono` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`estcedula`, `estnombre`, `estapellido`, `estdireccion`, `esttelefono`) VALUES
('1215721382', 'Rocio', 'Cevallos', 'San Juan', '0962869082'),
('1234567890', 'Dennis', 'Quisaguano', 'RelojAmbato', '0900000000'),
('1342567899', 'carlos', 'Vera', 'Santa', '0900000000'),
('1802998342', 'Alberto', 'Lopez', 'Ambato', '0934545454'),
('1804855367', 'Vero', 'Jaque', 'Tena', '0967854321'),
('1850452242', 'BRYAN', 'LOPEZ', 'S/A', '0900000000');

--
-- Disparadores `estudiantes`
--
DELIMITER $$
CREATE TRIGGER `EVITAR_BORRAR_ESTUDIANTE_MATRICULADO` BEFORE DELETE ON `estudiantes` FOR EACH ROW BEGIN
    DECLARE MATRICULAS_ACTIVAS INT;
    SELECT COUNT(*) INTO MATRICULAS_ACTIVAS FROM MATRICULAS WHERE ID_EST_PER = OLD.ESTCEDULA;
    IF MATRICULAS_ACTIVAS > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'ERROR: NO SE PUEDE ELIMINAR EL ESTUDIANTE PORQUE ESTÁ INSCRITO EN UN CURSO.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `forzar_mayusculas_estudiante` BEFORE INSERT ON `estudiantes` FOR EACH ROW BEGIN
    SET NEW.estnombre = UPPER(NEW.estnombre);
    SET NEW.estapellido = UPPER(NEW.estapellido);
    SET NEW.estdireccion = UPPER(NEW.estdireccion);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `forzar_mayusculas_estudiante_update` BEFORE UPDATE ON `estudiantes` FOR EACH ROW BEGIN
    SET NEW.estnombre = UPPER(NEW.estnombre);
    SET NEW.estapellido = UPPER(NEW.estapellido);
    SET NEW.estdireccion = UPPER(NEW.estdireccion);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `id_mat` int(11) NOT NULL,
  `id_cur_per` int(11) NOT NULL,
  `id_est_per` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `matriculas`
--

INSERT INTO `matriculas` (`id_mat`, `id_cur_per`, `id_est_per`) VALUES
(1, 6, '1804855367');

--
-- Disparadores `matriculas`
--
DELIMITER $$
CREATE TRIGGER `EVITAR_DUPLICIDAD_MATRICULA` BEFORE INSERT ON `matriculas` FOR EACH ROW BEGIN
    DECLARE EXISTE_MATRICULA INT;
    SELECT COUNT(*) INTO EXISTE_MATRICULA FROM MATRICULAS WHERE ID_EST_PER = NEW.ID_EST_PER AND ID_CUR_PER = NEW.ID_CUR_PER;
    IF EXISTE_MATRICULA > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'ERROR: EL ESTUDIANTE YA SE ENCUENTRA MATRICULADO EN ESTE CURSO.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipo_usuario` enum('administrador','secretaria') NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultima_conexion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `tipo_usuario`, `nombre_completo`, `email`, `estado`, `fecha_creacion`, `ultima_conexion`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'administrador', 'Administrator UTA', 'admin@uta.edu.ec', 'activo', '2025-12-05 20:13:52', '2026-02-24 15:52:39'),
(2, 'secretaria', '5d7845ac6ee7cfffafc5fe5f35cf666d', 'secretaria', 'María González', 'maria.gonzalez@uta.edu.ec', 'activo', '2025-12-05 20:13:52', '2025-12-08 05:02:55');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_cur`),
  ADD UNIQUE KEY `unique_nombre_carrera` (`nom_cur`,`des_cur`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`estcedula`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id_mat`),
  ADD KEY `id_cur_per` (`id_cur_per`),
  ADD KEY `id_est_per` (`id_est_per`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_cur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`id_cur_per`) REFERENCES `cursos` (`id_cur`),
  ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`id_est_per`) REFERENCES `estudiantes` (`estcedula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
