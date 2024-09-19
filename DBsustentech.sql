CREATE DATABASE sustentech;
USE sustentech;

CREATE TABLE `usuario`(
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
	`nome` varchar(255) NOT NULL,
	`email` varchar(255) UNIQUE NOT NULL,
	`senha` varchar(255) NOT NULL
);

CREATE TABLE `empresa`(
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
	`nome` varchar (255) NOT NULL,
	`segmento` varchar (255) NOT NULL,
	`custo_manutencao` varchar (255) NOT NULL,
	`periodo_manutencao` varchar (255) NOT NULL,
	`tipo_reuso` varchar (255) NOT NULL,
	`origem` varchar (255) DEFAULT NULL,
	`tratamento` varchar (255) DEFAULT NULL,
	`escoamento` varchar (255) DEFAULT NULL,
	`usuario` int NOT NULL,
	CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario`(`id`) ON DELETE CASCADE ON UPDATE no action
);

INSERT INTO usuario VALUES (1, 'admin', 'admin@sustentech.com.br', '25f9e794323b453885f5181f1b624d0b'),
						   (2, 'Blando Alexandre', 'blando.alexandre@sustentech.com.br', '25f9e794323b453885f5181f1b624d0b');

INSERT INTO empresa VALUES (1, 'Teste 1', 'Marketing', 'R$ 800,00', 'Semestral', 'Água Cinza', 'Pias, chuveiros e lava-louças', 'Tratamento fisio-químico', NULL, 1),
						   (2, 'Teste 2', 'Vestuário', 'R$ 400,00', 'Mensal', 'Reaproveitamento da Chuva', NULL, NULL, '0.85', 1);