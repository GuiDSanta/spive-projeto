CREATE DATABASE spive;

USE spive;

CREATE TABLE usuario(id int PRIMARY KEY AUTO_INCREMENT,
                    nome varchar(30) NOT NULL,
                    sobrenome varchar(70) NOT NULL,
					email varchar(100) NOT NULL UNIQUE,
                    senha varchar(60) NOT NULL,
                    cep char(8) NOT NULL,
                    logradouro varchar(100) NOT NULL,
                    numero char(10) NOT NULL,
                    cpf char(11) NOT NULL UNIQUE,
                    nascimento date NOT NULL,
                    telefone varchar(11) NOT NULL);
   

CREATE TABLE veiculo(
	id int PRIMARY KEY AUTO_INCREMENT,
    placa char(7) NOT NULL,
    marca varchar(20) NOT NULL,
    modelo varchar(30) NOT NULL,
    cor varchar(20) NOT NULL,
    proprietario_id int NOT NULL,
    FOREIGN KEY (proprietario_id) REFERENCES usuario(id),
	condutor_id int NOT NULL,
    FOREIGN KEY (condutor_id) REFERENCES usuario(id)
);
                    
select * from usuario;
delete from usuario WHERE email = 'gigi10.valdez@gmail.com';
drop table usuario;