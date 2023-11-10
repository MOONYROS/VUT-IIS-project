DROP TABLE Osoba_predmet;
DROP TABLE Rozvrh_aktivita;
DROP TABLE `Vyuk_aktivita`;
DROP TABLE `Mistnost`;
DROP TABLE `Rozvrh`;
DROP TABLE `Osoba`;
DROP TABLE `Predmet`;

CREATE TABLE `Osoba` (
	`ID_Osoba` INT(5) NOT NULL AUTO_INCREMENT,
	`jmeno` varchar(15) NOT NULL,
	`prijmeni` varchar(15) NOT NULL,
	`email` varchar(20) NOT NULL,
	`telefon` INT(9) NOT NULL,
    `role` varchar(4) NOT NULL,
	PRIMARY KEY (`ID_Osoba`)
);

CREATE TABLE `Predmet` (
	`zkratka` varchar(3) NOT NULL,
	`nazev` varchar(25) NOT NULL,
	`anotace` varchar(200) NOT NULL,
	`pocet_kreditu` INT(1) NOT NULL,
	`typ_ukonceni` varchar(6) NOT NULL,
	PRIMARY KEY (`zkratka`)
);

CREATE TABLE Osoba_predmet (
    `ID_Osoba` INT(5) NOT NULL,
    `zkratka` varchar(3) NOT NULL,
    PRIMARY KEY (ID_Osoba, zkratka),
    FOREIGN KEY (ID_Osoba) REFERENCES Osoba(ID_Osoba),
    FOREIGN KEY (zkratka) REFERENCES Predmet(zkratka)
);

CREATE TABLE `Mistnost` (
	`ID_mist` INT(5) NOT NULL AUTO_INCREMENT,
	`kapacita` INT(4) NOT NULL,
	`typ` varchar(15) NOT NULL,
	`popis` varchar(100) NOT NULL,
	`umisteni` varchar(20) NOT NULL,
	`admin` INT(5) NOT NULL,
	PRIMARY KEY (`ID_mist`),
    FOREIGN KEY (admin) REFERENCES Osoba(ID_Osoba)
);

CREATE TABLE `Vyuk_aktivita` (
	`ID_Aktiv` INT(5) NOT NULL AUTO_INCREMENT,
	`typ` varchar(10) NOT NULL,
	`delka` varchar(10) NOT NULL,
	`popis` varchar(100) NOT NULL,
	`opakovani` varchar(20) NOT NULL,
	`mistnost` INT(5) NOT NULL,
    `predmet` varchar(3) NOT NULL,
	PRIMARY KEY (`ID_Aktiv`),
    FOREIGN KEY (`predmet`) REFERENCES Predmet(zkratka),
    FOREIGN KEY (mistnost) REFERENCES Mistnost(ID_mist)
);

CREATE TABLE `Rozvrh` (
	`ID_Rozvrh` INT(5) NOT NULL AUTO_INCREMENT,
	`student` INT(5),
	`vyucujici` INT(5),
	`rozvrhar` INT(5) NOT NULL,
	PRIMARY KEY (`ID_Rozvrh`),
    FOREIGN KEY (student) REFERENCES Osoba(ID_Osoba),
    FOREIGN KEY (vyucujici) REFERENCES Osoba(ID_Osoba),
    FOREIGN KEY (rozvrhar) REFERENCES Osoba(ID_Osoba)
);

CREATE TABLE `Rozvrh_aktivita` (
    `ID_Rozvrh` INT(5) NOT NULL,
    `ID_Aktiv` INT(5) NOT NULL,
    PRIMARY KEY (ID_Rozvrh, ID_Aktiv),
    FOREIGN KEY (ID_Rozvrh) REFERENCES Rozvrh(ID_Rozvrh),
    FOREIGN KEY (ID_Aktiv) REFERENCES Vyuk_aktivita(ID_Aktiv)
);
