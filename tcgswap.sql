-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2023 a las 12:40:04
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tcgswap`
--
CREATE DATABASE IF NOT EXISTS `tcgswap` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tcgswap`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_oferta`
--

CREATE TABLE `articulos_oferta` (
  `id_oferta` int(11) NOT NULL,
  `id_carta` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `estado` varchar(2) NOT NULL,
  `idioma` varchar(2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articulos_oferta`
--

INSERT INTO `articulos_oferta` (`id_oferta`, `id_carta`, `id_user`, `estado`, `idioma`, `cantidad`) VALUES
(1, 4, 23, 'CN', 'ES', 1),
(1, 20, 23, 'US', 'ES', 1),
(1, 3, 20, 'EX', 'ES', 1),
(1, 15, 20, 'CN', 'ES', 1),
(2, 11, 25, 'EX', 'FR', 1),
(2, 23, 25, 'CN', 'ES', 3),
(2, 27, 25, 'EX', 'IN', 1),
(2, 15, 20, 'EX', 'ES', 1),
(2, 3, 20, 'EX', 'ES', 1),
(3, 20, 23, 'US', 'ES', 1),
(3, 20, 23, 'CN', 'FR', 1),
(3, 15, 20, 'MA', 'RU', 1),
(3, 15, 20, 'EX', 'AL', 1),
(3, 3, 20, 'EX', 'IN', 1),
(4, 6, 22, 'CN', 'ES', 2),
(4, 19, 23, 'CN', 'ES', 1),
(4, 18, 23, 'EX', 'FR', 1),
(5, 23, 25, 'CN', 'ES', 1),
(5, 5, 20, 'CN', 'ES', 1),
(5, 6, 20, 'CN', 'ES', 1);

--
-- Disparadores `articulos_oferta`
--
DELIMITER $$
CREATE TRIGGER `insartof_AI` AFTER INSERT ON `articulos_oferta` FOR EACH ROW BEGIN
	set @anular_trigger=1;
    DELETE FROM carrito where id_usu_carta=NEW.id_user AND id_carta=NEW.id_carta and estado=NEW.estado and idioma=NEW.idioma and cantidad=NEW.cantidad;
    set @anular_trigger=NULL;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_usu_carta` int(11) DEFAULT NULL,
  `id_carta` int(11) DEFAULT NULL,
  `estado` varchar(2) NOT NULL,
  `idioma` varchar(2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `carrito`
--
DELIMITER $$
CREATE TRIGGER `delcarr_AD` AFTER DELETE ON `carrito` FOR EACH ROW BEGIN
IF @anular_trigger IS NULL THEN
	IF EXISTS(SELECT * FROM coleccion_usu where id_usuario=OLD.id_usu_carta AND id_carta=OLD.id_carta and estado=OLD.estado and idioma=OLD.idioma) THEN
    	UPDATE coleccion_usu SET cantidad=cantidad+OLD.cantidad where id_usuario=OLD.id_usu_carta AND id_carta=OLD.id_carta and estado=OLD.estado and idioma=OLD.idioma;
    ELSE
    INSERT INTO coleccion_usu (id_usuario, id_carta, estado, idioma, cantidad) VALUES (OLD.id_usu_carta, OLD.id_carta, OLD.estado, OLD.idioma, OLD.cantidad);
    END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inscarr_AI` AFTER INSERT ON `carrito` FOR EACH ROW BEGIN
	UPDATE coleccion_usu SET cantidad=cantidad-1 where id_usuario=NEW.id_usu_carta AND id_carta=NEW.id_carta and estado=NEW.estado and idioma=NEW.idioma;
    DELETE from coleccion_usu where cantidad = 0;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `upcarr_AU` AFTER UPDATE ON `carrito` FOR EACH ROW BEGIN
	IF EXISTS(SELECT * FROM coleccion_usu where id_usuario=NEW.id_usu_carta AND id_carta=NEW.id_carta and estado=NEW.estado and idioma=NEW.idioma) THEN
    	UPDATE coleccion_usu SET cantidad=cantidad+OLD.cantidad-NEW.cantidad where id_usuario=NEW.id_usu_carta AND id_carta=NEW.id_carta and estado=NEW.estado and idioma=NEW.idioma;
    DELETE from coleccion_usu where cantidad = 0;
    ELSE
    INSERT INTO coleccion_usu (id_usuario, id_carta, estado, idioma, cantidad) VALUES (NEW.id_usu_carta, NEW.id_carta, NEW.estado, NEW.idioma, (OLD.cantidad-NEW.cantidad));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartas`
--

CREATE TABLE `cartas` (
  `id_carta` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `descCarta` varchar(255) NOT NULL,
  `rareza` varchar(2) NOT NULL DEFAULT 'CO' COMMENT '[CO]mun, [IN]frecuente, [RA]ra, [MI]tica',
  `camino_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cartas`
--

INSERT INTO `cartas` (`id_carta`, `nombre`, `descCarta`, `rareza`, `camino_img`) VALUES
(3, 'Automata-adaptativo', 'Cuando esta carta entra al campo de batalla, elige un tipo de criatura.\r\nEl Autómata Adaptativo es del tipo elegido además de sus otros tipos.\r\nLas otras criaturas que controlas del tipo elegido obtienen +1/+1.', 'RA', 'app/assets/imgCartas/adaptive-automaton.png'),
(4, 'Deposito-de-flujo-etereo', 'Siempre que lances un hechizo ganas una vida por cada hechizo que hayas lanzado este turno.<br>\r\nPagar 50 vidas: el Depósito de Flujo Etéreo hace 50 puntos de daño a cualquier objetivo.', 'MI', 'app/assets/imgCartas/aetherflux-reservoir.png'),
(5, 'Altar-de-la-demencia', 'Sacrificar una criatura: El jugador objetivo muele una cantidad de cartas igual a la fuerza de la criatura sacrificada.', 'MI', 'app/assets/imgCartas/altar-of-dementia.png'),
(6, 'Altar-de-Ashnod', 'Sacrificar una criatura: Agrega dos manás incoloros.', 'RA', 'app/assets/imgCartas/ashnod-s-altar.png'),
(7, 'Cornucopia-astral', 'Cornucopia astral entra al campo de batalla con X contadores de carga sobre ella.<br>\r\nGirar: Elige un color. Agrega un maná de ese color por cada contador de carga sobre Cornucopia astral.', 'RA', 'app/assets/imgCartas/astral-cornucopia.png'),
(8, 'Blackblade-reforjada', 'La criatura equipada obtiene +1/+1 por cada tierra que controlas.<br>\r\nEquipar criatura legendaria 3.<br>\r\nEquipar 7.', 'RA', 'app/assets/imgCartas/blackblade-reforged.png'),
(9, 'Sierra-de-hueso', 'La criatura equipada obtiene +1/+0.<br>\r\nEquipar 1.', 'IN', 'app/assets/imgCartas/bone-saw.png'),
(10, 'Venado-brunido', '3, sacrificar el Venado bruñido: Busca en tu biblioteca hasta dos cartas de tierra básica, ponlas en el campo de batalla giradas y luego baraja.', 'IN', 'app/assets/imgCartas/burnished-hart.png'),
(11, 'Sol-enjaulado', 'En cuanto el Sol enjaulado entre al campo de batalla, elige un color.<br>\r\nLas criaturas que controlas del color elegido obtienen +1/+1.<br>\r\nSiempre que una habilidad de una tierra te haga agregar uno o más manás del color elegido, agrega uno adicional.', 'MI', 'app/assets/imgCartas/caged-sun.png'),
(12, 'Linterna-cromatica', 'Las tierras que controlas obtienen \"Girar: Agrega un maná de cualquier color.\"<br>\r\nGirar: Agrega un maná de cualquier color.', 'RA', 'app/assets/imgCartas/chromatic-lantern.png'),
(13, 'Estrella-cromatica', '1, girar, sacrificar la Estrella cromática: Agrega un maná de cualquier color.<br>\r\nCuando la Estrella cromática vaya a un cementerio desde el campo de batalla, roba una carta.', 'IN', 'app/assets/imgCartas/chromatic-star.png'),
(14, 'Llave-de-nubes', 'En cuanto la llave de nubes entre al campo de batalla, elige entre artefacto, criatura, encantamiento, instantáneo o conjuro.<br>\r\nTe cuesta 1 menos lanzar hechizos del tipo elegido', 'RA', 'app/assets/imgCartas/cloud-key.png'),
(15, 'Rejilla-de-defensa', 'Cuesta 3 mas lanzar hechizos excepto durante el turno de su controlador', 'RA', 'app/assets/imgCartas/defense-grid.png'),
(16, 'Puerta-a-la-nada', 'La puerta a la nada entra al campo de batalla girada.<br>\r\n{2W}{2U}{2B}{2R}{2G}, girar, sacrificar la puerta a la nada: El jugador objetivo pierde el juego.', 'RA', 'app/assets/imgCartas/door-to-nothingness.png'),
(17, 'Frasco-de-otro-lugar', 'Cuando el Frasco de otro lugar entre al campo de batalla, roba una carta.<br>\r\nSacrificar el Frasco de otro lugar: Elige un tipo de tierra básica. Cada tierra que controlas es de ese tipo hasta el final del turno.', 'IN', 'app/assets/imgCartas/elsewhere-flask.png'),
(18, 'Inspector-de-la-fundicion', 'Te cuesta 1 menos lanzar los hechizos de artefacto', 'IN', 'app/assets/imgCartas/foundry-inspector.png'),
(19, 'Loto-de-oropel', 'Girar: Agrega tres manás de un color cualquiera', 'RA', 'app/assets/imgCartas/gilded-lotus.png'),
(20, 'Lanzaesquirlas-trasgo', '3, girar: Muestra cartas de la parte superior de la biblioteca hasta que muestres una carta de tierra. Hace daño a cualquier objetivo igual a la cantidad de cartas mostrada. Si la tierra es una montaña, hace el doble de daño.', 'RA', 'app/assets/imgCartas/goblin-charbelcher.png'),
(21, 'Yelmo-multiplicador', 'Al comienzo del combate en tu turno, crea una ficha que es una copia de la criatura equipada, salvo que la ficha no es legendaria si la equipada lo es. Esa ficha gana la habilidad de prisa. <br>\r\nEquipar 5.', 'MI', 'app/assets/imgCartas/helm-of-the-host.png'),
(22, 'Mina-aullante', 'Al comienzo del paso de robar de cada jugador, si la Mina aullante está enderezada, ese jugador roba una carta adicional.', 'RA', 'app/assets/imgCartas/howling-mine.png'),
(23, 'Manantial-icorido', 'Cuando el Manantial icórido entre al campo de batalla o vaya a un cementerio desde el campo de batalla, roba una carta.', 'IN', 'app/assets/imgCartas/ichor-wellspring.png'),
(24, 'Estatuas-inspiradoras', 'Los hechizos que no sean de artefacto que lances tienen la habilidad de improvisar.', 'RA', 'app/assets/imgCartas/inspiring-statuary.png'),
(25, 'Torre-de-marfil', 'Al comienzo de tu mantenimiento ganas X vidas, donde X es la cantidad de cartas en tu mano menos 4.', 'IN', 'app/assets/imgCartas/ivory-tower.png'),
(26, 'Volumen-de-Jalum', '2, girar: Roba una carta, luego descarta una carta.', 'IN', 'app/assets/imgCartas/jalum-tome.png'),
(27, 'Cometa-del-viajante', '3, girar: Busca en tu biblioteca una carta de tierra básica, muéstrala, ponla en tu mano y luego baraja.', 'RA', 'app/assets/imgCartas/journeyer-s-kite.png'),
(28, 'Piedra-atormentadora', '5, girar: El jugador objetivo muele X cartas, donde X es la cantidad de cartas en el cementerio de ese jugador.', 'RA', 'app/assets/imgCartas/keening-stone.png'),
(29, 'Llave-de-la-ciudad', 'Girar, descartar una carta: Hasta una criatura objetivo no puede ser bloqueada este turno.<br>\r\nSiempre que la Llave de la ciudad se enderece, puedes pagar 2. Si lo haces, roba una carta.', 'RA', 'app/assets/imgCartas/key-to-the-city.png'),
(30, 'Capa-de-metal-liquido', 'Girar: el permanente objetivo se convierte en un artefacto además de sus otros tipos hasta el final del turno.', 'IN', 'app/assets/imgCartas/liquimetal-coating.png'),
(31, 'Golem-de-piedraiman', 'Cuesta 1 más lanzar hechizos que no sean de artefacto.', 'RA', 'app/assets/imgCartas/lodestone-golem.png'),
(32, 'Tomo-pierdementes', 'Girar, poner un contador sobre el Tomo pierdementes: Adivina 1.<br>\r\n2, girar, poner un contador sobre el Tomo pierdementes: Roba una carta.<br>\r\nCuando haya cuatro o más contadores sobre el Tomo pierdementes, exílialo. Si lo haces, ganas 4 vidas.', 'RA', '/app/assets/imgCartas/mazemind-tome.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coleccion_usu`
--

CREATE TABLE `coleccion_usu` (
  `id_entrada` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_carta` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL DEFAULT 'CN' COMMENT '[CN]CasiNuevo, [EX]celente,\r\n[BI]en,\r\n[US]ada,\r\n[MA]l',
  `idioma` varchar(2) NOT NULL DEFAULT 'ES' COMMENT '[ES]pañol, [IN]gles, [FR]ances, [AL]eman, [IT]aliano, [RU]so'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `coleccion_usu`
--

INSERT INTO `coleccion_usu` (`id_entrada`, `id_usuario`, `id_carta`, `cantidad`, `estado`, `idioma`) VALUES
(30, 23, 4, 2, 'CN', 'ES'),
(31, 23, 20, 2, 'US', 'ES'),
(33, 23, 20, 1, 'CN', 'AL'),
(34, 23, 30, 3, 'CN', 'ES'),
(35, 23, 30, 1, 'US', 'IN'),
(36, 23, 24, 3, 'BI', 'IN'),
(37, 23, 24, 1, 'CN', 'ES'),
(38, 23, 25, 3, 'EX', 'ES'),
(39, 23, 25, 2, 'BI', 'IT'),
(40, 23, 19, 4, 'CN', 'ES'),
(41, 23, 18, 4, 'EX', 'FR'),
(42, 24, 8, 1, 'CN', 'FR'),
(43, 24, 8, 2, 'CN', 'ES'),
(45, 24, 21, 3, 'BI', 'ES'),
(46, 24, 21, 2, 'CN', 'ES'),
(47, 24, 29, 3, 'EX', 'IN'),
(48, 24, 29, 2, 'CN', 'ES'),
(49, 25, 10, 3, 'CN', 'ES'),
(51, 25, 22, 1, 'CN', 'ES'),
(52, 25, 11, 2, 'EX', 'FR'),
(54, 25, 27, 2, 'EX', 'IN'),
(55, 25, 26, 4, 'EX', 'AL'),
(57, 25, 22, 4, 'EX', 'RU'),
(66, 22, 6, 2, 'CN', 'ES'),
(68, 22, 17, 1, 'CN', 'ES'),
(72, 22, 15, 1, 'BI', 'FR'),
(92, 20, 15, 2, 'CN', 'ES'),
(94, 20, 15, 1, 'EX', 'ES'),
(97, 20, 6, 1, 'CN', 'ES'),
(98, 20, 5, 2, 'CN', 'ES'),
(99, 20, 17, 1, 'CN', 'ES'),
(100, 22, 8, 1, 'CN', 'ES'),
(101, 22, 17, 1, 'CN', 'AL'),
(102, 22, 17, 1, 'EX', 'ES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversacion`
--

CREATE TABLE `conversacion` (
  `id_conv` int(11) NOT NULL,
  `id_user1` int(11) DEFAULT NULL,
  `id_user2` int(11) DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_ultimo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `conversacion`
--

INSERT INTO `conversacion` (`id_conv`, `id_user1`, `id_user2`, `fecha_inicio`, `fecha_ultimo`) VALUES
(10, 23, 20, '2023-05-21 19:26:13', '2023-05-21 23:16:04'),
(11, 23, 22, '2023-05-21 19:30:03', '2023-05-21 19:30:03'),
(12, 20, 22, '2023-06-05 17:21:42', '2023-06-05 17:21:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conv_mensaje`
--

CREATE TABLE `conv_mensaje` (
  `id_mens` int(18) NOT NULL,
  `id_conv` int(11) DEFAULT NULL,
  `id_remi` int(11) DEFAULT NULL,
  `id_dest` int(11) DEFAULT NULL,
  `mensaje` varchar(1600) NOT NULL,
  `fecha_creado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `conv_mensaje`
--

INSERT INTO `conv_mensaje` (`id_mens`, `id_conv`, `id_remi`, `id_dest`, `mensaje`, `fecha_creado`) VALUES
(100, 10, 23, 20, 'Hola buenas tardes', '2023-05-21 19:26:13'),
(101, 10, 23, 20, 'Por aqui se va para allá?', '2023-05-21 19:26:19'),
(102, 11, 23, 22, 'Tenemos un problema importante aqui eh', '2023-05-21 19:30:03'),
(103, 10, 23, 20, 'Ay señor', '2023-05-21 19:31:08'),
(117, 10, 20, 23, 'Y esto aqui como se ve', '2023-05-21 22:04:10'),
(118, 10, 20, 23, 'Ah bueno', '2023-05-21 22:04:14'),
(140, 12, 20, 22, 'Buenas, me interesa esta carta', '2023-06-05 17:21:42');

--
-- Disparadores `conv_mensaje`
--
DELIMITER $$
CREATE TRIGGER `insmens_AI` AFTER INSERT ON `conv_mensaje` FOR EACH ROW BEGIN
	IF EXISTS(SELECT id_conv FROM conversacion where (id_user1=NEW.id_remi OR id_user2=NEW.id_remi) AND (id_user1=NEW.id_dest OR id_user2=NEW.id_dest)) THEN
        UPDATE conversacion SET fecha_ultimo=NEW.fecha_creado where (id_user1=NEW.id_remi OR id_user2=NEW.id_remi) AND (id_user1=NEW.id_dest OR id_user2=NEW.id_dest);
    ELSE
    INSERT INTO conversacion (id_user1, id_user2, fecha_inicio, fecha_ultimo) VALUES (NEW.id_remi, NEW.id_dest, NEW.fecha_creado, NEW.fecha_creado);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insmens_BI` BEFORE INSERT ON `conv_mensaje` FOR EACH ROW BEGIN
IF EXISTS(SELECT id_conv FROM conversacion where (id_user1=NEW.id_remi OR id_user2=NEW.id_remi) AND (id_user1=NEW.id_dest OR id_user2=NEW.id_dest)) THEN
 SET NEW.id_conv=(SELECT id_conv FROM conversacion where (id_user1=NEW.id_remi OR id_user2=NEW.id_remi) AND (id_user1=NEW.id_dest OR id_user2=NEW.id_dest));
 ELSE
 INSERT INTO conversacion (id_user1, id_user2, fecha_inicio, fecha_ultimo) VALUES (NEW.id_remi, NEW.id_dest, NEW.fecha_creado, NEW.fecha_creado);
 SET NEW.id_conv=(SELECT id_conv FROM conversacion where (id_user1=NEW.id_remi OR id_user2=NEW.id_remi) AND (id_user1=NEW.id_dest OR id_user2=NEW.id_dest));
 END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `id_envio` int(11) NOT NULL,
  `id_oferta` int(11) NOT NULL,
  `id_user1` int(11) DEFAULT NULL,
  `status_user1` varchar(2) NOT NULL COMMENT '[SE] Sin Enviar, [EN]viado, [FI]nalizado',
  `id_user2` int(11) DEFAULT NULL,
  `status_user2` varchar(2) NOT NULL COMMENT '[SE] Sin Enviar, [EN]viado, [FI]nalizado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE `oferta` (
  `id_oferta` int(11) NOT NULL,
  `id_user_oferta` int(11) DEFAULT NULL,
  `id_user_recibe` int(11) DEFAULT NULL,
  `fecha_oferta` date NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'EN' COMMENT '[EN]viada, [OK] Aceptada, [NO] Rechazada, [FI]nalizada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `oferta`
--

INSERT INTO `oferta` (`id_oferta`, `id_user_oferta`, `id_user_recibe`, `fecha_oferta`, `status`) VALUES
(1, 20, 23, '2023-03-09', 'NO'),
(2, 20, 25, '2023-03-11', 'EN'),
(3, 20, 23, '2023-03-11', 'EN'),
(4, 23, 22, '2023-05-29', 'EN'),
(5, 20, 25, '2023-06-06', 'EN');

--
-- Disparadores `oferta`
--
DELIMITER $$
CREATE TRIGGER `upofer_AU` AFTER UPDATE ON `oferta` FOR EACH ROW BEGIN
IF NEW.status = 'NO' THEN
    INSERT INTO coleccion_usu (id_entrada, id_usuario, id_carta, cantidad, estado, idioma)
    SELECT NULL, ao.id_user, ao.id_carta, ao.cantidad, ao.estado, ao.idioma
    FROM articulos_oferta ao
    WHERE ao.id_oferta = NEW.id_oferta
    ON DUPLICATE KEY UPDATE cantidad = coleccion_usu.cantidad + ao.cantidad;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `nombre_completo` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `localidad` varchar(15) NOT NULL,
  `codpostal` varchar(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  `puntuacion` int(11) NOT NULL DEFAULT 0,
  `transacciones` int(11) NOT NULL DEFAULT 0,
  `disponible` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 si, 0 no',
  `fecha_creacion` date NOT NULL,
  `fecha_nac` date NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 Activo\r\n0 Inactivo',
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `username`, `password`, `nombre`, `nombre_completo`, `direccion`, `localidad`, `codpostal`, `email`, `puntuacion`, `transacciones`, `disponible`, `fecha_creacion`, `fecha_nac`, `activo`, `token`) VALUES
(20, 'dariusmtg', '12345', 'Dario', 'Dario Fribidis', 'Gil Cordero 12', 'Caceres', '10001', 'dario.estevez@educarex.es', 0, 0, 1, '2023-02-23', '2005-02-01', 1, '4650f316c946941f7bd2feb11e5f614b'),
(22, 'cormoran', '12345', 'Curro', 'Jimenez', 'asdfasdfasdf', 'Vigo', '12348', 'lalalalal@gmail.com', 0, 0, 1, '2023-02-24', '1995-07-11', 1, ''),
(23, 'kentuki', '12345', 'Pepe', 'Pepe Cartujo', 'asdfasdfasdfasdf asdfasdfasdf', 'Valladolid', '23244', 'fasdfasdfasdfer@gmail.com', 0, 0, 1, '2023-03-05', '2005-03-01', 1, '01e208f87427ca96ba087fdfd6ff87b1'),
(24, 'eleven23', '12345', 'Pedro', 'Pedro Eleven', 'Perfidia 10', 'Valladolid', '23242', 'fasdfasdfasdfer@hotmail.com', 0, 0, 1, '2023-03-05', '2005-01-26', 1, '419e56e8a7b8d9a5bacb8dfafaa13835'),
(25, 'venancio2', '12345', 'Venancio', 'Venancio de Pueblo', 'Cumingo 2', 'El Bierzo', '53245', 'fasdfasdfasdfer@yahoo.com', 0, 0, 1, '2023-03-05', '2004-08-17', 1, '61f2785b3beaa6859e803feb91527f9d');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_puntuacion`
--

CREATE TABLE `usuario_puntuacion` (
  `id_punt` int(11) NOT NULL,
  `id_envio` int(11) NOT NULL,
  `id_user_punt` int(11) DEFAULT NULL,
  `id_user_env` int(11) DEFAULT NULL,
  `punt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos_oferta`
--
ALTER TABLE `articulos_oferta`
  ADD KEY `id_oferta` (`id_oferta`),
  ADD KEY `id_carta` (`id_carta`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usu_carta` (`id_usu_carta`),
  ADD KEY `id_carta` (`id_carta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `cartas`
--
ALTER TABLE `cartas`
  ADD PRIMARY KEY (`id_carta`);

--
-- Indices de la tabla `coleccion_usu`
--
ALTER TABLE `coleccion_usu`
  ADD PRIMARY KEY (`id_entrada`),
  ADD UNIQUE KEY `indice_todo` (`id_usuario`,`id_carta`,`estado`,`idioma`) USING BTREE,
  ADD KEY `id_carta` (`id_carta`) USING BTREE,
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE;

--
-- Indices de la tabla `conversacion`
--
ALTER TABLE `conversacion`
  ADD PRIMARY KEY (`id_conv`),
  ADD KEY `id_envia` (`id_user1`),
  ADD KEY `id_recibe` (`id_user2`);

--
-- Indices de la tabla `conv_mensaje`
--
ALTER TABLE `conv_mensaje`
  ADD PRIMARY KEY (`id_mens`),
  ADD KEY `id_remi` (`id_remi`),
  ADD KEY `id_dest` (`id_dest`),
  ADD KEY `id_conv` (`id_conv`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`id_envio`),
  ADD KEY `id_user1` (`id_user1`),
  ADD KEY `id_user2` (`id_user2`),
  ADD KEY `id_oferta` (`id_oferta`) USING BTREE;

--
-- Indices de la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id_oferta`),
  ADD KEY `id_user_oferta` (`id_user_oferta`),
  ADD KEY `id_user_recibe` (`id_user_recibe`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usu`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usuario_puntuacion`
--
ALTER TABLE `usuario_puntuacion`
  ADD PRIMARY KEY (`id_punt`),
  ADD KEY `id_envio` (`id_envio`),
  ADD KEY `id_user_punt` (`id_user_punt`),
  ADD KEY `id_user_env` (`id_user_env`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `cartas`
--
ALTER TABLE `cartas`
  MODIFY `id_carta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `coleccion_usu`
--
ALTER TABLE `coleccion_usu`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `conversacion`
--
ALTER TABLE `conversacion`
  MODIFY `id_conv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `conv_mensaje`
--
ALTER TABLE `conv_mensaje`
  MODIFY `id_mens` int(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `id_envio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id_oferta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `usuario_puntuacion`
--
ALTER TABLE `usuario_puntuacion`
  MODIFY `id_punt` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos_oferta`
--
ALTER TABLE `articulos_oferta`
  ADD CONSTRAINT `articulos_oferta_ibfk_1` FOREIGN KEY (`id_oferta`) REFERENCES `oferta` (`id_oferta`) ON DELETE CASCADE,
  ADD CONSTRAINT `articulos_oferta_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL,
  ADD CONSTRAINT `articulos_oferta_ibfk_4` FOREIGN KEY (`id_carta`) REFERENCES `cartas` (`id_carta`) ON DELETE SET NULL;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_usu_carta`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_3` FOREIGN KEY (`id_carta`) REFERENCES `cartas` (`id_carta`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_4` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `coleccion_usu`
--
ALTER TABLE `coleccion_usu`
  ADD CONSTRAINT `coleccion_usu_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `coleccion_usu_ibfk_2` FOREIGN KEY (`id_carta`) REFERENCES `cartas` (`id_carta`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `conversacion`
--
ALTER TABLE `conversacion`
  ADD CONSTRAINT `conversacion_ibfk_1` FOREIGN KEY (`id_user1`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL,
  ADD CONSTRAINT `conversacion_ibfk_2` FOREIGN KEY (`id_user2`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL;

--
-- Filtros para la tabla `conv_mensaje`
--
ALTER TABLE `conv_mensaje`
  ADD CONSTRAINT `conv_mensaje_ibfk_2` FOREIGN KEY (`id_remi`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL,
  ADD CONSTRAINT `conv_mensaje_ibfk_3` FOREIGN KEY (`id_dest`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL,
  ADD CONSTRAINT `conv_mensaje_ibfk_4` FOREIGN KEY (`id_conv`) REFERENCES `conversacion` (`id_conv`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `envio_ibfk_1` FOREIGN KEY (`id_oferta`) REFERENCES `oferta` (`id_oferta`) ON DELETE CASCADE,
  ADD CONSTRAINT `envio_ibfk_2` FOREIGN KEY (`id_user1`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL,
  ADD CONSTRAINT `envio_ibfk_3` FOREIGN KEY (`id_user2`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL;

--
-- Filtros para la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD CONSTRAINT `oferta_ibfk_1` FOREIGN KEY (`id_user_oferta`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL,
  ADD CONSTRAINT `oferta_ibfk_2` FOREIGN KEY (`id_user_recibe`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuario_puntuacion`
--
ALTER TABLE `usuario_puntuacion`
  ADD CONSTRAINT `usuario_puntuacion_ibfk_1` FOREIGN KEY (`id_user_punt`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL,
  ADD CONSTRAINT `usuario_puntuacion_ibfk_2` FOREIGN KEY (`id_user_env`) REFERENCES `usuarios` (`id_usu`) ON DELETE SET NULL,
  ADD CONSTRAINT `usuario_puntuacion_ibfk_3` FOREIGN KEY (`id_envio`) REFERENCES `envio` (`id_envio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
