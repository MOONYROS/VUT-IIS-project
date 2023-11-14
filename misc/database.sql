DROP TABLE Osoba_predmet;
DROP TABLE Rozvrh_aktivita;
DROP TABLE Vyuk_aktivita;
DROP TABLE Mistnost;
DROP TABLE Rozvrh;
DROP TABLE Osoba;
DROP TABLE Predmet;

CREATE TABLE Osoba (
	ID_Osoba INT(5) NOT NULL AUTO_INCREMENT,
	jmeno varchar(15) NOT NULL,
	prijmeni varchar(15) NOT NULL,
	email varchar(20) NOT NULL,
    heslo varchar(255) NOT NULL, -- Ideal password length by the documentation
	telefon INT(9) NOT NULL,
    role varchar(4) NOT NULL, -- ADMI, STUD, ROZV, GARA, VYUC
	PRIMARY KEY (ID_Osoba)
);

CREATE TABLE Predmet (
	zkratka varchar(3) NOT NULL,
	nazev varchar(25) NOT NULL,
	anotace varchar(200) NOT NULL,
	pocet_kreditu INT(1) NOT NULL,
	typ_ukonceni varchar(6) NOT NULL,
	PRIMARY KEY (zkratka)
);

CREATE TABLE Osoba_predmet (
    ID_Osoba INT(5) NOT NULL,
    zkratka varchar(3) NOT NULL,
    PRIMARY KEY (ID_Osoba, zkratka),
    FOREIGN KEY (ID_Osoba) REFERENCES Osoba(ID_Osoba),
    FOREIGN KEY (zkratka) REFERENCES Predmet(zkratka)
);

CREATE TABLE Mistnost (
	ID_mist varchar(6) NOT NULL,
	kapacita INT(4) NOT NULL,
	typ varchar(15) NOT NULL,
	popis varchar(100) NOT NULL,
	umisteni varchar(20) NOT NULL,
	PRIMARY KEY (`ID_mist`)
);

CREATE TABLE Vyuk_aktivita (
	ID_Aktiv INT(5) NOT NULL AUTO_INCREMENT,
	typ varchar(10) NOT NULL,
	delka varchar(10) NOT NULL,
	popis varchar(100) NOT NULL,
	opakovani varchar(20) NOT NULL,
	mistnost varchar(5) NOT NULL,
    predmet varchar(3) NOT NULL,
	PRIMARY KEY (ID_Aktiv),
    FOREIGN KEY (predmet) REFERENCES Predmet(zkratka),
    FOREIGN KEY (mistnost) REFERENCES Mistnost(ID_mist)
);

CREATE TABLE Rozvrh (
	ID_Rozvrh INT(5) NOT NULL AUTO_INCREMENT,
	student INT(5),
	vyucujici INT(5),
	rozvrhar INT(5) NOT NULL,
	PRIMARY KEY (`ID_Rozvrh`),
    FOREIGN KEY (student) REFERENCES Osoba(ID_Osoba),
    FOREIGN KEY (vyucujici) REFERENCES Osoba(ID_Osoba),
    FOREIGN KEY (rozvrhar) REFERENCES Osoba(ID_Osoba)
);

CREATE TABLE Rozvrh_aktivita (
    ID_Rozvrh INT(5) NOT NULL,
    ID_Aktiv INT(5) NOT NULL,
    PRIMARY KEY (ID_Rozvrh, ID_Aktiv),
    FOREIGN KEY (ID_Rozvrh) REFERENCES Rozvrh(ID_Rozvrh),
    FOREIGN KEY (ID_Aktiv) REFERENCES Vyuk_aktivita(ID_Aktiv)
);

# SAMPLOVI UZIVATELE
-- heslo "admin"
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (1, "admin", "admin", "admin@admin.admin", "$2y$10$krWfrVmZh6PVfES6TeEJWe18dEV8l.ZLvvyEgE0wLvRKcFtYhMhGC", 111111111, "admi");

-- heslo "student"
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (2, "student", "student", "stud@stud.stud", "$2y$10$.7uByVdYNUtMT6zWvIvLYeL1tXWLnV17JBE.a9lq6Y.ChTjtMD3Z6", 123123123, "stud");

-- heslo "vyucujici"
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (3, "vyucujici", "vyucujici", "vyuc@vyuc.vyuc", "$2y$10$zEdObEn2JwT8wjNDUPrWcODBUfJaMoN9YLH02jH.7ZB.c0.cENgaS", 123412341, "vyuc");

-- heslo "rozvrhar"
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (4, "rozvrhar", "rozvrhar", "rozv@rozv.rozv", "$2y$10$Fw3uu/mQiX3V74XLoKZZguCjggMITIOIxSJC2JFysCrF2EAPUcxLO", 123456789, "rozv");

-- heslo "garant"
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (5, "garant", "garant", "gara@gara.gara", "$2y$10$yYDldR4XAP3dZ49qCydMmON/lprRgyc2IE/bzrKbYsLHDDXE1QoXq", 987654321, "gara");

# SAMPLOVE PREDMETY
INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni)
VALUES ("IZP", "Zaklady programovani", "Predmet o zakladech programovani v jazyce C.", 7, "zazk");

INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni)
VALUES ("IOS", "Operacni systemy", "Naprosta deadly silenost o tom, jak funguji operacni systemy.", 5, "zazk");

INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni)
VALUES ("IEL", "Elektronika pro FIT", "Nejaky zaklady o elektronice, rezistory, tranzistory, etc.", 5, "zazk");

INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni)
VALUES ("HVR", "Vedeni tymu", "Dalsi to-be-banger predmet se Silvii.", 3, "za");

INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni)
VALUES ("ITU", "Tvorba UI", "Predmet, ktery taky bude naprosta silenost s divnymi pravidly.", 5, "klza");

# SAMPLOVE MISTNOSTI
INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ("C127.1", 6, "studovna", "Naprosto banger roomka.", "knihovna");

INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ("D105", 380, "poslucharna", "Nejvetsi prednaskovka na celym FITu. Celkem solid.", "u fontany");

INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ("Q202", 8, "pracovna", "Pracovna grafiku z FITu, jako treba gigachada Mileta.", "chodba k menze");

INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ("M202", 1500, "chodba", "Chodba okolo CVT k menze.", "u CVTcka");

INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ("S207", 12, "studovna", "Velka studovna v Sku, kdysi tam byla spatna wifi, tedka uz to celkem jde.", "oddelena budova");
