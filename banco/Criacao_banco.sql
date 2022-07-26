CREATE database `lgreversa`;
USE lgreversa;

CREATE TABLE `RegistroEncomenda` (
  `idregistroenc` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `codigo` varchar(30) NOT NULL,
  `remetente` varchar(150) NOT NULL,
  `idtipoencomenda` int NOT NULL,
  `dataregistro` datetime NOT NULL DEFAULT now(),
  `idstatusentrega` int NOT NULL,
  `registroObservacao` varchar(300),
  `idsetor` int NOT NULL,
  `datacoleta` date NOT NULL,
  `idusuario` int NOT NULL,
  `dataentregasetor` datetime,
  `Idusuarioaltera` int
);

CREATE TABLE `BackLogRegisEntrada` (
  `idRegistroEnvio` int NOT NULL,
  `data` datetime NOT NULL DEFAULT now(),
  `campo` varchar(50),
  `dados_antigo` varchar(100),
  `dados_novo` varchar(100)
);

CREATE TABLE `usuario` (
  `idusuario` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nome` varchar(50),
  `ipcomputador` varchar(50) NOT NULL,
  `nivel` int NOT NULL,
  `idsetor` int
);

CREATE TABLE `statusentrega` (
  `idstatusentrega` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `descstatusentrega` varchar(30) NOT NULL
);

CREATE TABLE `setor` (
  `idsetor` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `descsetor` varchar(255) NOT NULL,
  `statusAtivo` int NOT NULL
);

CREATE TABLE `tipoencomenda` (
  `idtipoencomenda` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `desctipoencomenda` varchar(50) NOT NULL,
  `statusAtivo` int NOT NULL
);

CREATE TABLE `RegistroEncomendaEnvioCorreio` (
  `idRegistroEncomendaEnvioCorreio` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `idtransporte` int NOT NULL,
  `dataregistro` datetime NOT NULL DEFAULT now(),
  `idtipoencomenda` int NOT NULL,
  `idstatusentrega` int NOT NULL,
  `setorRemetente` int NOT NULL,
  `idusuarioNewRegistro` int NOT NULL,
  `idtipoEnvio` int NOT NULL,
  `Nomefuncionario` varchar(200),
  `Endereco` varchar(200) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `codigopostagem` varchar(50),
  `datapostagem` date,
  `complementarend` varchar(100),
  `observacaoenvio` varchar(300),
  `idusuarioalteracao` int
);

CREATE TABLE `BackLogRegisEnvio` (
  `idRegistroEnvio` int NOT NULL,
  `data` datetime NOT NULL DEFAULT now(),
  `campo` varchar(50),
  `dados_antigo` varchar(100),
  `dados_novo` varchar(100)
);

CREATE TABLE `tipoEnvio` (
  `idtipoEnvio` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `desctipoEnvio` varchar(50),
  `statusAtivo` int NOT NULL
);

CREATE TABLE `Statusativacao` (
  `idStatusAtivacao` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `descStatus` varchar(20)
);

ALTER TABLE `usuario` ADD FOREIGN KEY (`idsetor`) REFERENCES `setor` (`idsetor`);

ALTER TABLE `RegistroEncomendaEnvioCorreio` ADD FOREIGN KEY (`idusuarioNewRegistro`) REFERENCES `usuario` (`idusuario`);

ALTER TABLE `RegistroEncomendaEnvioCorreio` ADD FOREIGN KEY (`idstatusentrega`) REFERENCES `statusentrega` (`idstatusentrega`);

ALTER TABLE `RegistroEncomenda` ADD FOREIGN KEY (`idtipoencomenda`) REFERENCES `tipoencomenda` (`idtipoencomenda`);

ALTER TABLE `RegistroEncomenda` ADD FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

ALTER TABLE `RegistroEncomendaEnvioCorreio` ADD FOREIGN KEY (`setorRemetente`) REFERENCES `setor` (`idsetor`);

ALTER TABLE `RegistroEncomendaEnvioCorreio` ADD FOREIGN KEY (`idtipoencomenda`) REFERENCES `tipoencomenda` (`idtipoencomenda`);

ALTER TABLE `RegistroEncomenda` ADD FOREIGN KEY (`idsetor`) REFERENCES `setor` (`idsetor`);

ALTER TABLE `RegistroEncomenda` ADD FOREIGN KEY (`idstatusentrega`) REFERENCES `statusentrega` (`idstatusentrega`);

ALTER TABLE `RegistroEncomendaEnvioCorreio` ADD FOREIGN KEY (`idtipoEnvio`) REFERENCES `tipoEnvio` (`idtipoEnvio`);

ALTER TABLE `setor` ADD FOREIGN KEY (`statusAtivo`) REFERENCES `StatusAtivacao` (`idStatusAtivacao`);

ALTER TABLE `tipoEnvio` ADD FOREIGN KEY (`statusAtivo`) REFERENCES `StatusAtivacao` (`idStatusAtivacao`);

ALTER TABLE `tipoencomenda` ADD FOREIGN KEY (`statusAtivo`) REFERENCES `StatusAtivacao` (`idStatusAtivacao`);

ALTER TABLE `BackLogRegisEnvio` ADD FOREIGN KEY (`idRegistroEnvio`) REFERENCES `RegistroEncomendaEnvioCorreio` (`idRegistroEncomendaEnvioCorreio`);

ALTER TABLE `BackLogRegisEntrada` ADD FOREIGN KEY (`idRegistroEnvio`) REFERENCES `RegistroEncomenda` (`idregistroenc`);

insert into  usuario (nome,ipcomputador,nivel) VALUES ("Cleiton","192.168.2.202","1");


insert into  StatusAtivacao (descStatus) VALUES ("Ativo");
insert into  StatusAtivacao (descStatus) VALUES ("Desativo");

INSERT INTO statusentrega (descstatusentrega) VALUES ("Pendente");
INSERT INTO statusentrega (descstatusentrega) VALUES ("Entregue");
INSERT INTO statusentrega (descstatusentrega) VALUES ("Preparo");
INSERT INTO statusentrega (descstatusentrega) VALUES ("Negado");