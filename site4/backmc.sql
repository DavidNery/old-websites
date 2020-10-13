CREATE TABLE `cargos` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(30) UNIQUE NOT NULL,
  `cor` enum('green','blue','red','yellow','purple','') NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `equipe` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `usuario` varchar(20) NOT NULL,
  `cargo` int(11) NOT NULL,
  FOREIGN KEY(cargo) REFERENCES cargos(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `regras` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `descricao` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `usuarios` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `senha` char(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `loja` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `nome` VARCHAR(25) NOT NULL UNIQUE,
  `link` VARCHAR(250) NOT NULL,
  `imagem` VARCHAR(250)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;