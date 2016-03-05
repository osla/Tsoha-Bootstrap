CREATE TABLE Laitos(
	laitosID SERIAL PRIMARY KEY,
	laitoksenNimi varchar(50) NOT NULL
);

CREATE TABLE Org_luokka(
	luokkaID SERIAL PRIMARY KEY,
	luokanNimi varchar(50) NOT NULL
);

CREATE TABLE Kysymys(
	kysymysID SERIAL PRIMARY KEY,
	kuvaus varchar(200) NOT NULL,
	vastausLuokka varchar(50) NOT NULL
);

CREATE TABLE Opiskelija(
	opiskelijaID SERIAL PRIMARY KEY,
	sposti varchar(50) NOT NULL
);

CREATE TABLE Kayttaja(
	kayttajaID varchar(50) PRIMARY KEY,
	kayttajanNimi varchar(100) NOT NULL,
	salasana varchar(50) NOT NULL,
	admin boolean DEFAULT FALSE
);

CREATE TABLE Kurssi(
	kurssiID SERIAL PRIMARY KEY,
	kurssinNimi varchar(50) NOT NULL,
	vastuuopettajaID varchar(50) REFERENCES Kayttaja(kayttajaID) ON DELETE CASCADE,
	laitosID INTEGER REFERENCES Laitos(laitosID) ON DELETE CASCADE
);

CREATE TABLE Kysely(
	kyselyID SERIAL PRIMARY KEY,
	kyselynNimi varchar(50) NOT NULL,
	kurssiID INTEGER REFERENCES Kurssi(kurssiID) ON DELETE CASCADE,
	alkupvm DATE,
	loppupvm DATE,
	tila boolean DEFAULT FALSE
);

CREATE TABLE Osallistumislista(
	opiskelijaID INTEGER REFERENCES Opiskelija(opiskelijaID) ON DELETE CASCADE,
	kurssiID INTEGER REFERENCES Kurssi(kurssiID) ON DELETE CASCADE
);

CREATE TABLE Kyselylista(
	kayttajaID varchar(50) REFERENCES Kayttaja(kayttajaID) ON DELETE CASCADE,
	kyselyID INTEGER REFERENCES Kysely(kyselyID) ON DELETE CASCADE,
	PRIMARY KEY (kayttajaID, kyselyID)
);

CREATE TABLE Vastauslista(
	kyselyID INTEGER REFERENCES Kysely(kyselyID) ON DELETE CASCADE,
	kysymysID INTEGER REFERENCES Kysymys(kysymysID) ON DELETE CASCADE,
	vastaus varchar(500)
);

CREATE TABLE Kysymyslista(
	kyselyID INTEGER REFERENCES Kysely(kyselyID) ON DELETE CASCADE,
	kysymysID INTEGER REFERENCES Kysymys(kysymysID) ON DELETE CASCADE,
	luokkaID INTEGER REFERENCES Org_luokka(luokkaID) ON DELETE CASCADE
);