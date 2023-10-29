CREATE TABLE `Predmet` (
	`zkratka` varchar(3) NOT NULL,
	`nazev` varchar(25) NOT NULL,
	`anotace` varchar(200) NOT NULL,
	`pocet_kreditu` INT(1) NOT NULL,
	`typ_ukonceni` varchar(6) NOT NULL,
	`garant` INT(5) NOT NULL,
	`vyucujici` INT(5) NOT NULL,
	`student` INT(5) NOT NULL,
	`admin` INT(5) NOT NULL,
	`vyuk_aktivita` INT(5) NOT NULL,
	PRIMARY KEY (`zkratka`)
);

CREATE TABLE `Garant` (
	`ID_Garant` INT(5) NOT NULL AUTO_INCREMENT,
	`jmeno` varchar(15) NOT NULL,
	`prijmeni` varchar(15) NOT NULL,
	`email` varchar(20) NOT NULL,
	`telefon` INT(9) NOT NULL,
	PRIMARY KEY (`ID_Garant`)
);

CREATE TABLE `Vyucujici` (
	`ID_Vyuc` INT(5) NOT NULL AUTO_INCREMENT,
	`jmeno` varchar(15) NOT NULL,
	`prijmeni` varchar(15) NOT NULL,
	`email` varchar(20) NOT NULL,
	`telefon` INT(9) NOT NULL,
	PRIMARY KEY (`ID_Vyuc`)
);

CREATE TABLE `Student` (
	`ID_Stud` INT(5) NOT NULL AUTO_INCREMENT,
	`jmeno` varchar(15) NOT NULL,
	`prijmeni` varchar(15) NOT NULL,
	`email` varchar(20) NOT NULL,
	`telefon` INT(9) NOT NULL,
	PRIMARY KEY (`ID_Stud`)
);

CREATE TABLE `Rozvrhar` (
	`ID_Rozvrhar` INT(5) NOT NULL AUTO_INCREMENT,
	`jmeno` varchar(15) NOT NULL,
	`prijmeni` varchar(15) NOT NULL,
	`email` varchar(20) NOT NULL,
	`telefon` INT(9) NOT NULL,
	PRIMARY KEY (`ID_Rozvrhar`)
);

CREATE TABLE `Administrator` (
	`ID_Admin` INT(5) NOT NULL AUTO_INCREMENT,
	`jmeno` varchar(15) NOT NULL,
	`prijmeni` varchar(15) NOT NULL,
	`email` varchar(20) NOT NULL,
	`telefon` INT(9) NOT NULL,
	PRIMARY KEY (`ID_Admin`)
);

CREATE TABLE `Vyuk_aktivita` (
	`ID_Aktiv` INT(5) NOT NULL AUTO_INCREMENT,
	`typ` varchar(10) NOT NULL,
	`delka` varchar(10) NOT NULL,
	`popis` varchar(100) NOT NULL,
	`opakovani` varchar(20) NOT NULL,
	`mistnost` INT(5) NOT NULL,
	PRIMARY KEY (`ID_Aktiv`)
);

CREATE TABLE `Mistnost` (
	`ID_mist` INT(5) NOT NULL AUTO_INCREMENT,
	`kapacita` INT(4) NOT NULL,
	`typ` varchar(15) NOT NULL,
	`popis` varchar(100) NOT NULL,
	`umisteni` varchar(20) NOT NULL,
	`admin` INT(5) NOT NULL,
	PRIMARY KEY (`ID_mist`)
);

CREATE TABLE `Rozvrh` (
	`ID_Rozvrh` INT(5) NOT NULL AUTO_INCREMENT,
	`vyuk_aktivita` INT(5) NOT NULL,
	`student` INT(5) NOT NULL,
	`vyucujici` INT(5) NOT NULL,
	`rozvrhar` INT(5) NOT NULL,
	PRIMARY KEY (`ID_Rozvrh`)
);

ALTER TABLE `Predmet` ADD CONSTRAINT `Predmet_fk0` FOREIGN KEY (`garant`) REFERENCES `Garant`(`ID_Garant`);

ALTER TABLE `Predmet` ADD CONSTRAINT `Predmet_fk1` FOREIGN KEY (`vyucujici`) REFERENCES `Vyucujici`(`ID_Vyuc`);

ALTER TABLE `Predmet` ADD CONSTRAINT `Predmet_fk2` FOREIGN KEY (`student`) REFERENCES `Student`(`ID_Stud`);

ALTER TABLE `Predmet` ADD CONSTRAINT `Predmet_fk3` FOREIGN KEY (`admin`) REFERENCES `Administrator`(`ID_Admin`);

ALTER TABLE `Predmet` ADD CONSTRAINT `Predmet_fk4` FOREIGN KEY (`vyuk_aktivita`) REFERENCES `Vyuk_aktivita`(`ID_Aktiv`);

ALTER TABLE `Vyuk_aktivita` ADD CONSTRAINT `Vyuk_aktivita_fk0` FOREIGN KEY (`mistnost`) REFERENCES `Mistnost`(`ID_mist`);

ALTER TABLE `Mistnost` ADD CONSTRAINT `Mistnost_fk0` FOREIGN KEY (`admin`) REFERENCES `Administrator`(`ID_Admin`);

ALTER TABLE `Rozvrh` ADD CONSTRAINT `Rozvrh_fk0` FOREIGN KEY (`vyuk_aktivita`) REFERENCES `Vyuk_aktivita`(`ID_Aktiv`);

ALTER TABLE `Rozvrh` ADD CONSTRAINT `Rozvrh_fk1` FOREIGN KEY (`student`) REFERENCES `Student`(`ID_Stud`);

ALTER TABLE `Rozvrh` ADD CONSTRAINT `Rozvrh_fk2` FOREIGN KEY (`vyucujici`) REFERENCES `Vyucujici`(`ID_Vyuc`);

ALTER TABLE `Rozvrh` ADD CONSTRAINT `Rozvrh_fk3` FOREIGN KEY (`rozvrhar`) REFERENCES `Rozvrhar`(`ID_Rozvrhar`);

SELECT * FROM Administrator;
