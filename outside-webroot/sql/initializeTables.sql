DROP DATABASE IF EXISTS db_project;
CREATE DATABASE db_project;

USE db_project;

CREATE TABLE uzytkownicy
(
    login            VARCHAR(30) PRIMARY KEY,
    haslo            TEXT                                     NOT NULL,
    poziom_uprawnien ENUM ('administrator', 'menadzer', 'sprzedawca') NOT NULL
);

CREATE TABLE logi
(
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    data       DATETIME DEFAULT NOW(),
    uzytkownik VARCHAR(30) NOT NULL,
    opis_akcji TEXT NOT NULL,
    FOREIGN KEY (uzytkownik) REFERENCES uzytkownicy (login)
);

CREATE TABLE rachunki
(
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    data       DATETIME DEFAULT NOW(),
    uzytkownik VARCHAR(30) NOT NULL,
    FOREIGN KEY (uzytkownik) REFERENCES uzytkownicy (login)
);

CREATE TABLE przedmioty
(
    id    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cena  DECIMAL(10, 2) NOT NULL,
    vat   DECIMAL(2, 2)  NOT NULL,
    nazwa VARCHAR(30)    NOT NULL,
    CONSTRAINT vat_check CHECK (vat >= 0),
    CONSTRAINT cena_check CHECK (cena >= 0)
);

CREATE TABLE pozycje
(
    id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    przedmiot INT UNSIGNED,
    ilosc     INT UNSIGNED NOT NULL,
    rabat     DECIMAL(2, 2),
    CONSTRAINT rabat_check CHECK (rabat >= 0),
    FOREIGN KEY (przedmiot) REFERENCES przedmioty (id)
);

CREATE TABLE rachunki_pozycje
(
    rachunek INT UNSIGNED,
    pozycja  INT UNSIGNED,
    PRIMARY KEY (rachunek, pozycja),
    FOREIGN KEY (rachunek) REFERENCES rachunki (id),
    FOREIGN KEY (pozycja) REFERENCES pozycje (id)
);
