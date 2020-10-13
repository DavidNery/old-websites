CREATE TABLE usuario (
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(25) NOT NULL,
    senha VARCHAR(32) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
	frase VARCHAR(100) DEFAULT "Um membro da equipe",
    fotoName VARCHAR(50),
    fotoType VARCHAR(30),
    fotoSize BIGINT
) AUTO_INCREMENT = 1;

CREATE TABLE categoria (
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(25) NOT NULL UNIQUE
);

CREATE TABLE postagem (
	id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(50) NOT NULL UNIQUE,
    conteudo LONGTEXT NOT NULL,
    descricao VARCHAR(100) NOT NULL,
    postado DATETIME NOT NULL,
	views INT NOT NULL DEFAULT 0,
    fotoName VARCHAR(50),
    fotoType VARCHAR(30),
    fotoSize BIGINT,
    usuario INT NOT NULL,
    
    FOREIGN KEY(usuario) REFERENCES usuario(id)
);

CREATE TABLE postagemcategoria (
	postagem INT NOT NULL,
	categoria INT NOT NULL,
	
	PRIMARY KEY(postagem, categoria),
	FOREIGN KEY(postagem) REFERENCES postagem(id),
	FOREIGN KEY(categoria) REFERENCES categoria(id)
);