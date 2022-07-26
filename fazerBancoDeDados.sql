CREATE DATABASE bandeja;
USE bandeja;

CREATE TABLE usuarios(
	usuarioID INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR(255) NOT NULL UNIQUE,
	senha VARCHAR(255) NOT NULL,
	PRIMARY KEY (usuarioID)
);

CREATE TABLE receitas(
	receitaID NOT NULL AUTO_INCREMENT,
	titulo VARCHAR(255) NOT NULL,
	imagemURL VARCHAR(550) NOT NULL,
	tempo VARCHAR(15) DEFAULT 'Não Informado',
	usuario_ID INT NOT NULL,
	rendimento VARCHAR(15) DEFAULT 'Não Informado',
	favoritos_numeros BIGINT DEFAULT 0,
	descricao TEXT,
	preparo TEXT NOT NULL,
	PRIMARY KEY (receitaID),
	FOREIGN KEY (usuario_ID) REFERENCES usuarios(usuarioID)
);

CREATE TABLE ingredientes(
	ingredienteID INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR(255) NOT NULL UNIQUE,
	PRIMARY KEY (ingredienteID)
);

CREATE TABLE favoritos(
	favoritoID BIGINT NOT NULL AUTO_INCREMENT,
	autor_ID INT NOT NULL,
	receita_ID INT NOT NULL,
	PRIMARY KEY (favoritoID),
	FOREIGN KEY (autor_ID) REFERENCES usuarios(usuarioID),
	FOREIGN KEY (receita_ID) REFERENCES receitas(receitaID)
);

CREATE TABLE comentarios(
	comentarioID BIGINT NOT NULL AUTO_INCREMENT,
	conteudo TEXT,
	autor_ID INT NOT NULL,
	receita_ID INT NOT NULL, 
	PRIMARY KEY (comentarioID)
	FOREIGN KEY (autor_ID) REFERENCES usuarios(usuarioID),
	FOREIGN KEY (receita_ID) REFERENCES receitas(receitaID)
);