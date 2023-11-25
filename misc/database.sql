DROP TABLE Osoba_predmet;
DROP TABLE Rozvrh_aktivita;
DROP TABLE Vyuk_aktivita;
DROP TABLE Mistnost;
DROP TABLE Rozvrh;
DROP TABLE Predmet;
DROP TABLE Osoba;

ALTER DATABASE mydatabase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE Osoba (
	ID_Osoba INT(5) NOT NULL AUTO_INCREMENT,
	jmeno varchar(15) NOT NULL,
	prijmeni varchar(15) NOT NULL,
	email varchar(50) NOT NULL,
    heslo varchar(255) NOT NULL, -- Ideal password length by the documentation
	telefon INT(9) NOT NULL,
    role varchar(4) NOT NULL, -- ADMI, STUD, ROZV, VYUC
	PRIMARY KEY (ID_Osoba)
);

CREATE TABLE Predmet (
	zkratka varchar(3) NOT NULL,
	nazev varchar(25) NOT NULL,
	anotace varchar(200) NOT NULL,
	pocet_kreditu INT(1) NOT NULL,
	typ_ukonceni varchar(6) NOT NULL,
    garant int(5),
	PRIMARY KEY (zkratka),
    FOREIGN KEY (garant) REFERENCES Osoba(ID_Osoba) ON DELETE SET NULL
);

CREATE TABLE Osoba_predmet (
    ID_Osoba INT(5) NOT NULL,
    zkratka varchar(3) NOT NULL,
    zadost varchar(255),
    PRIMARY KEY (ID_Osoba, zkratka),
    FOREIGN KEY (ID_Osoba) REFERENCES Osoba(ID_Osoba) ON DELETE CASCADE,
    FOREIGN KEY (zkratka) REFERENCES Predmet(zkratka)
);

CREATE TABLE Mistnost (
	ID_mist varchar(6) NOT NULL,
	kapacita INT(4) NOT NULL,
	typ varchar(15) NOT NULL,
	popis varchar(100) NOT NULL,
	umisteni varchar(20) NOT NULL,
	PRIMARY KEY (ID_mist)
);

CREATE TABLE Vyuk_aktivita (
	ID_Aktiv INT(5) NOT NULL AUTO_INCREMENT,
	typ varchar(10) NOT NULL,
	delka int(2),
	popis varchar(100) NOT NULL,
    pozadavek varchar(200),
	opakovani varchar(20) NOT NULL,
	mistnost varchar(6),
    predmet varchar(3) NOT NULL,
    start int(2),
    den varchar(2),
    vyucujici INT(5),
	PRIMARY KEY (ID_Aktiv),
    FOREIGN KEY (predmet) REFERENCES Predmet(zkratka),
    FOREIGN KEY (mistnost) REFERENCES Mistnost(ID_mist),
    FOREIGN KEY (vyucujici) REFERENCES Osoba(ID_Osoba)
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
-- heslo 'admin'
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (1, 'admin', 'adminovaty', 'admin@admin.admin', '$2y$10$krWfrVmZh6PVfES6TeEJWe18dEV8l.ZLvvyEgE0wLvRKcFtYhMhGC', 111111111, 'admi');

-- heslo 'student'
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (2, 'student', 'studentsky', 'stud@stud.stud', '$2y$10$.7uByVdYNUtMT6zWvIvLYeL1tXWLnV17JBE.a9lq6Y.ChTjtMD3Z6', 123123123, 'stud');

-- heslo 'vyucujici'
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (3, 'vyucujici', 'Mucici', 'vyuc@vyuc.vyuc', '$2y$10$zEdObEn2JwT8wjNDUPrWcODBUfJaMoN9YLH02jH.7ZB.c0.cENgaS', 123412341, 'vyuc');

-- heslo 'vyucujici'
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (4, 'Doktor', 'Doktorsky', 'vyucitel@vyucitel.vyuc', '$2y$10$zEdObEn2JwT8wjNDUPrWcODBUfJaMoN9YLH02jH.7ZB.c0.cENgaS', 123412341, 'vyuc');

-- heslo 'vyucujici'
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (6, 'Učtel', 'Naškole', 'ucitel@ucitel.uc', '$2y$10$zEdObEn2JwT8wjNDUPrWcODBUfJaMoN9YLH02jH.7ZB.c0.cENgaS', 922922922, 'vyuc');

-- heslo 'vyucujici'
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (7, 'Van', 'Helsing', 'van@helsing.vh', '$2y$10$zEdObEn2JwT8wjNDUPrWcODBUfJaMoN9YLH02jH.7ZB.c0.cENgaS', 666666666, 'vyuc');

-- heslo 'rozvrhar'
INSERT INTO Osoba (ID_Osoba, jmeno, prijmeni, email, heslo, telefon, role)
VALUES (5, 'rozvrhar', 'rozvrzeny', 'rozv@rozv.rozv', '$2y$10$Fw3uu/mQiX3V74XLoKZZguCjggMITIOIxSJC2JFysCrF2EAPUcxLO', 123456789, 'rozv');

# SAMPLOVE PREDMETY
INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni, garant)
VALUES ('IZP', 'Zaklady programovani', 'Predmet o zakladech programovani v jazyce C.', 7, 'zazk', 3);

INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni, garant)
VALUES ('IOS', 'Operacni systemy', 'Naprosta deadly silenost o tom, jak funguji operacni systemy.', 5, 'zazk', 3);

INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni, garant)
VALUES ('IEL', 'Elektronika pro FIT', 'Nejaky zaklady o elektronice, rezistory, tranzistory, etc.', 5, 'zazk', 4);

INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni, garant)
VALUES ('HVR', 'Vedeni tymu', 'Dalsi to-be-banger predmet se Silvii.', 3, 'za', 4);

INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni, garant)
VALUES ('ITU', 'Tvorba UI', 'Predmet, ktery taky bude naprosta silenost s divnymi pravidly.', 5, 'klza', 3);

# SAMPLE GARANTI V KURZU
INSERT INTO Osoba_predmet (zkratka, ID_Osoba)
VALUES ('IZP', 3);

INSERT INTO Osoba_predmet (zkratka, ID_Osoba)
VALUES ('IOS', 3);

INSERT INTO Osoba_predmet (zkratka, ID_Osoba)
VALUES ('IEL', 4);

INSERT INTO Osoba_predmet (zkratka, ID_Osoba)
VALUES ('HVR', 4);

INSERT INTO Osoba_predmet (zkratka, ID_Osoba)
VALUES ('ITU', 3);

# SAMPLOVE MISTNOSTI
INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ('C127.1', 6, 'studovna', 'Naprosto banger roomka.', 'knihovna');

INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ('D105', 380, 'poslucharna', 'Nejvetsi prednaskovka na celym FITu. Celkem solid.', 'u fontany');

INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ('Q202', 8, 'pracovna', 'Pracovna grafiku z FITu, jako treba gigachada Mileta.', 'chodba k menze');

INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ('M202', 1500, 'chodba', 'Chodba okolo CVT k menze.', 'u CVTcka');

INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni)
VALUES ('S207', 12, 'studovna', 'Velka studovna v Sku, kdysi tam byla spatna wifi, tedka uz to celkem jde.', 'oddelena budova');

# SAMPLE VYUCUJICI V KURZU
INSERT INTO Osoba_predmet (ID_Osoba, zkratka) VALUES (3, 'IEL');
INSERT INTO Osoba_predmet (ID_Osoba, zkratka) VALUES (3, 'HVR');

# SAMPLE VYUKOVE AKTIVITY
# IOS
INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('prednaska', 3, 'Celkem nekonečný maraton o operačních systémech.', 'Prosím v pondělí', 'KT', 'IOS');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'IOS ma teď cvičení.', 'Prosím mimo prednasku IOS', 'ST', 'IOS');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'IOS ma teď cvičení.', 'Prosím mimo prednasku IOS', 'LT', 'IOS');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('zkouska', 4, 'Dva turnusy hned za sebou.', 'Prosím na pátek', 'JR', 'IOS');

# IEL
INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('prednaska', 3, 'Zajímavosti o obvodech.', 'Prosím v uterý', 'KT', 'IEL');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení.', '', 'ST', 'IEL');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení.', '', 'LT', 'IEL');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení.', '', 'ST', 'IEL');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení.', '', 'LT', 'IEL');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('zkouska', 2, 'Předtermín 1.', 'Prosím dopoledne', 'JR', 'IEL');

# IZP
INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('prednaska', 3, 'Naprosté základy programování v C.', 'Někdy odpoledne', 'KT', 'IZP');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení.', '', 'KT', 'IZP');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení.', '', 'KT', 'IZP');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení.', '', 'KT', 'IZP');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení.', '', 'KT', 'IZP');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('zkouska', 2, 'Předtermín 1.', 'Pátek večer prosím.', 'JR', 'IZP');

# ITU
INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('prednaska', 3, 'Naučme se navrhovat uživatelská rozhraní.', 'Středa 10 dík', 'KT', 'ITU');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení FIGMA.', 'Počítačouvou laboratoř.', 'JR', 'ITU');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení QT.', 'Počítačouvou laboratoř.', 'JR', 'ITU');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 2, 'Laboratorní cvičení WINAPI.', 'Počítačouvou laboratoř.', 'JR', 'ITU');

# HVR
INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 5, 'Naučme se pracovat s lidmi.', 'Potřebuju pondělí.', 'ST', 'HVR');

INSERT INTO Vyuk_aktivita (typ, delka, popis, pozadavek, opakovani, predmet )
VALUES ('cviceni', 5, 'Naučme se pracovat s lidmi.', 'Potřebuju pondělí.', 'LT', 'HVR');
