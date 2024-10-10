DROP DATABASE sustentech;
CREATE DATABASE sustentech;
USE sustentech;

CREATE TABLE `usuario`(
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
	`nome` varchar(255) NOT NULL,
	`email` varchar(255) UNIQUE NOT NULL,
	`senha` varchar(255) NOT NULL,
	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	`is_deleted` boolean NOT NULL DEFAULT false
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
	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	`is_deleted` boolean NOT NULL DEFAULT false,
	CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario`(`id`) ON DELETE CASCADE ON UPDATE no action
);

CREATE TABLE `consumo`(
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
	`valor` varchar (255) NOT NULL,
	`custo` varchar (255) NOT NULL,
	`referencia` varchar (255) NOT NULL,
	`reuso` varchar (255) NOT NULL,
	`empresa` int NOT NULL,
	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	`is_deleted` boolean NOT NULL DEFAULT false,
	CONSTRAINT `fk_empresa` FOREIGN KEY (`empresa`) REFERENCES `empresa`(`id`) ON DELETE CASCADE ON UPDATE no action
);

INSERT INTO usuario(`nome`, `email`, `senha`) 
			VALUES ('admin', 'admin@sustentech.com.br', '25f9e794323b453885f5181f1b624d0b'),
				   ('Blando Alexandre', 'blando.alexandre@sustentech.com.br', '25f9e794323b453885f5181f1b624d0b');

INSERT INTO empresa(`nome`, `segmento`, `custo_manutencao`, `periodo_manutencao`, `tipo_reuso`, `origem`, `tratamento`, `escoamento`, `usuario`) 
		 	VALUES ('Teste 1', 'Marketing', '800.00', 'Semestral', 'agua-cinza', 'Pias, chuveiros e lava-louças', 'Tratamento fisio-químico', NULL, 1),
				   ('Teste 2', 'Vestuário', '400.00', 'Mensal', 'reaproveitamento-da-chuva', NULL, NULL, '0.85', 1);

INSERT INTO consumo(`valor`, `custo`, `referencia`, `reuso`, `empresa`, `is_deleted`) 
			VALUES ('100', '300,00', '2024-09-13', '80', 1, 0),
				   ('100', '300,00', '2024-07-10', '80', 1, 0),
				   ('100', '300,00', '1999-12-31', '80', 1, 1),
				   ('100', '300,00', '2024-10-05', '80', 1, 0),
				   ('100', '300,00', '2024-08-16', '80', 1, 0),
				   ('100', '300,00', '1999-12-31', '80', 1, 1),
				   ('100', '300,00', '2024-06-10', '80', 1, 0),
				   ('100', '300,00', '2000-01-02', '80', 1, 1),
				   ('100', '300,00', '2000-01-03', '80', 1, 1),
				   ('100', '300,00', '2000-01-04', '80', 1, 1),
				   ('100', '300,00', '2000-01-05', '80', 1, 1),
				   ('100', '300,00', '2000-01-06', '80', 1, 1),
				   ('100', '300,00', '2000-01-07', '80', 1, 1),
				   ('100', '300,00', '2000-01-08', '80', 1, 1),
				   ('100', '300,00', '2000-01-09', '80', 1, 1),
				   ('100', '300,00', '2024-05-10', '80', 1, 0);