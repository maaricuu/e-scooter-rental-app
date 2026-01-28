CREATE TABLE KORISNIK (
    id_korisnika VARCHAR(20) PRIMARY KEY,
    k_ime VARCHAR(50) NOT NULL,
    k_prezime VARCHAR(50) NOT NULL,
    k_email VARCHAR(100) NOT NULL UNIQUE,
    br_telefona VARCHAR(20) NOT NULL,
    datum_registracije DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE TROTINET (
    id_trotineta VARCHAR(20) PRIMARY KEY,
    status VARCHAR(20) NOT NULL CHECK (status IN ('slobodan','zauzet'))
);

CREATE TABLE VOZNJA (
    id_voznje VARCHAR(20) PRIMARY KEY,
    id_korisnika VARCHAR(20) NOT NULL,
    id_trotineta VARCHAR(20) NOT NULL,
    vreme_pocetka_voznje DATETIME DEFAULT CURRENT_TIMESTAMP,
    vreme_zavrsetka_voznje DATETIME NULL,
    cena_po_minutu INT NOT NULL DEFAULT 10.00
);


INSERT INTO TROTINET (id_trotineta, status) VALUES
('t001', 'slobodan'),
('t002', 'slobodan'),
('t003', 'slobodan'),
('t004', 'slobodan'),
('t005', 'slobodan'),
('t006', 'slobodan'),
('t007', 'slobodan'),
('t008', 'slobodan'),
('t009', 'slobodan'),
('t010', 'slobodan'),
('t011', 'slobodan'),
('t012', 'slobodan'),
('t013', 'slobodan'),
('t014', 'slobodan'),
('t015', 'slobodan');


CREATE TABLE KORISNICKA_PRIJAVA (
    id_prijave INT AUTO_INCREMENT PRIMARY KEY,
    opis_prijave VARCHAR(100) NOT NULL,
    id_korisnika VARCHAR(20) NOT NULL,
    id_trotineta VARCHAR(10) NOT NULL
    
);
CREATE TABLE TRANSAKCIJA (
    id_transakcije VARCHAR(10) PRIMARY KEY,
    id_voznje VARCHAR(10) NOT NULL,
    id_korisnika VARCHAR(10) NOT NULL,
    id_trotineta VARCHAR(10) NOT NULL,
    datum_transakcije DATETIME NOT NULL
);


CREATE TABLE ZAPOSLENI (
    id_zaposlenog VARCHAR(10) PRIMARY KEY,
    ime_zaposlenog VARCHAR(50) NOT NULL,
    prezime_zaposlenog VARCHAR(50) NOT NULL
);

INSERT INTO ZAPOSLENI (id_zaposlenog, ime_zaposlenog, prezime_zaposlenog) VALUES
('zap001', 'Marko', 'Petrović'),
('zap002', 'Jelena', 'Jovanović'),
('zap003', 'Nikola', 'Stanković'),
('zap004', 'Ana', 'Milošević'),
('zap005', 'Stefan', 'Đorđević'),
('zap006', 'Ivana', 'Nikolić'),
('zap007', 'Petar', 'Kovačević'),
('zap008', 'Milica', 'Savić'),
('zap009', 'Luka', 'Vasić'),
('zap010', 'Tamara', 'Ilić');


CREATE TABLE SERVIS (
    id_servisa VARCHAR(10) PRIMARY KEY,
    naziv_servisa VARCHAR(100) NOT NULL,
    lokacija_servisa VARCHAR(100) NOT NULL,
    kontakt_servisa VARCHAR(20) NOT NULL
);

INSERT INTO SERVIS (id_servisa, naziv_servisa, lokacija_servisa, kontakt_servisa) VALUES
('servis1', 'E-Trotinet Centar', 'Dorćol', '+381641234567'),
('servis2', 'Eco Ride Servis', 'Novi Beograd', '+381638765432'),
('servis3', 'Urban Wheels', 'Zvezdara', '+381621112233'),
('servis4', 'Green Mobility', 'Voždovac', '+381655554444'),
('servis5', 'Smart Scooter Hub', 'Banovo Brdo', '+381607778889');


CREATE TABLE SERVISIRANJE (
    id_posla VARCHAR(10) PRIMARY KEY,
    opis_posla VARCHAR(100) NOT NULL,
    cena_posla INT NOT NULL
);

INSERT INTO SERVISIRANJE(id_posla, opis_posla, cena_posla) VALUES
('posao1', 'Popravka', '5000'),
('posao2', 'Održavanje', '3000'),
('posao3','Punjenje', '1500');

CREATE TABLE PRIJAVA_SERVISU (
    opis_posla VARCHAR(100) NOT NULL,
    id_servisa VARCHAR(10) NOT NULL,
    id_trotineta VARCHAR(10) NOT NULL
);

CREATE TABLE FAKTURA (
    id_fakture INT AUTO_INCREMENT PRIMARY KEY,
    opis_posla VARCHAR(100) NOT NULL,
    id_servisa VARCHAR(10) NOT NULL,
    datum_servisiranja DATETIME NOT NULL,
    id_trotineta VARCHAR(10) NOT NULL
);
CREATE TABLE PLACANJE (
    id_placanja INT AUTO_INCREMENT PRIMARY KEY,
    id_fakture INT NOT NULL,
    datum_placanja DATETIME NOT NULL
);

