CREATE DATABASE spive;

USE spive;

drop database spive;

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
   

   
CREATE TABLE proprietario(
	id int PRIMARY KEY,
    nome varchar(100) NOT NULL,
    cpf char(11) NOT NULL,
    cnh char(9) NOT NULL,
    categoria varchar(3) NOT NULL
);

drop table veiculo;
drop table proprietario;
drop table dispositivo;

CREATE TABLE veiculo(
	id_veiculo int PRIMARY KEY AUTO_INCREMENT,
    placa char(7) NOT NULL,
    marca varchar(20) NOT NULL,
    modelo varchar(30) NOT NULL,
    cor varchar(20) NOT NULL,
    proprietario_id int NOT NULL,
    FOREIGN KEY (proprietario_id) REFERENCES proprietario(id),
	condutor_id int NOT NULL,
    FOREIGN KEY (condutor_id) REFERENCES usuario(id)

);

alter table veiculo add foto varchar(500) null after cor;
 
 CREATE TABLE dispositivo(
	id int PRIMARY KEY AUTO_INCREMENT,
    vidro_aberto bool NOT NULL,
	temperatura int NOT NULL,
    umidade int NOT NULL,
    presenca bool NOT NULL,
    oxigenio int NOT NULL,
    perigo_temp bool NOT NULL,
    perigo_oxi bool NOT NULL,
    ar_ligado bool NOT NULL,
    veiculo_id int NOT NULL,
    FOREIGN KEY (veiculo_id) REFERENCES veiculo(id_veiculo)
);
 
 insert into dispositivo (vidro_aberto,temperatura,umidade,presenca,oxigenio,perigo_temp,perigo_oxi,ar_ligado,veiculo_id)
 values (false,25,70,true,2500,false,false,true,1);
 insert into veiculo (placa,marca,modelo,cor,proprietario_id,condutor_id) values ('GTV2231','NISSAN','SENTRA','PRATA',5,5);
 insert into veiculo (placa,marca,modelo,cor,proprietario_id,condutor_id) values ('XJU5712','CHEVROLET','TRACKER','AZUL',5,5);

select * from usuario;
select * from veiculo;
select * from proprietario;
delete from usuario WHERE email = 'gigi10.valdez@gmail.com';
drop table usuario;