-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Opiskelija (sposti) VALUES ('mikko.mallikas@helsinki.fi');
INSERT INTO Opiskelija (sposti) VALUES ('timo.mallikas@helsinki.fi');
INSERT INTO Laitos (laitoksenNimi) VALUES ('tietojenkäsittelytieteen laitos');
INSERT INTO Kayttaja (kayttajanNimi, kayttajanSposti, salasana) VALUES ('Opettaja, Olli', 'olli.opettaja@helsinki.fi', 'olli123');
INSERT INTO Kayttaja (kayttajanNimi, kayttajanSposti, salasana) VALUES ('Mallikas, Mikko', 'mikko.mallikas@helsinki.fi', 'mikko123');
INSERT INTO Kurssi (kurssinNimi) VALUES ('Ohjelmistotuotanto');
INSERT INTO Kurssi (kurssinNimi) VALUES ('Johdatus tietojenkäsittelytieteeseen');
INSERT INTO Kysely (kyselynnimi, tekijaid, kurssiID, tila) VALUES ('Ohtu syksy 2015', '1', '1', 'false');
INSERT INTO Kysely (kyselynnimi, tekijaid, kurssiID, tila) VALUES ('Ohtu vuodenvaihde 2015', '2', '1', 'true');