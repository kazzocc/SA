create database tccSA;
use tccSA;
create table tb_usuarios (
	id int PRIMARY KEY AUTO_INCREMENT,
	nome  varchar(100),
    email varchar(255),
    senha varchar(100),
	tipo integer -- 0 para "aluno" e 1 para "professor" e 2 para servidor
);