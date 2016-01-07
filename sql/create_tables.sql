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
	kayttajaID SERIAL PRIMARY KEY,
	kayttajanNimi varchar(50) NOT NULL,
	kayttajanSposti varchar(50) NOT NULL,
	salasana varchar(50) NOT NULL
);

CREATE TABLE Kurssi(
	kurssiID SERIAL PRIMARY KEY,
	kurssinNimi varchar(50) NOT NULL,
	vastuuopettajaID INTEGER REFERENCES Kayttaja(kayttajaID),
	laitosID INTEGER REFERENCES Laitos(laitosID)
);

CREATE TABLE Kysely(
	kyselyID SERIAL PRIMARY KEY,
	kyselynNimi varchar(50) NOT NULL,
	kurssiID INTEGER REFERENCES Kurssi(kurssiID),
	alkupvm DATE,
	loppupvm DATE,
	muokattu DATE,
	tila boolean DEFAULT FALSE
);

CREATE TABLE Osallistumislista(
	opiskelijaID INTEGER REFERENCES Opiskelija(opiskelijaID),
	kurssiID INTEGER REFERENCES Kurssi(kurssiID)
);

CREATE TABLE Kyselylista(
	kayttajaID INTEGER REFERENCES Kayttaja(kayttajaID),
	kyselyID INTEGER REFERENCES Kysely(kyselyID)
);

CREATE TABLE Vastauslista(
	kyselyID INTEGER REFERENCES Kysely(kyselyID),
	kysymysID INTEGER REFERENCES Kysymys(kysymysID),
	vastaus varchar(500)
);

CREATE TABLE Kysymyslista(
	kyselyID INTEGER REFERENCES Kysely(kyselyID),
	kysymysID INTEGER REFERENCES Kysymys(kysymysID),
	luokkaID INTEGER REFERENCES Org_luokka(luokkaID)
);