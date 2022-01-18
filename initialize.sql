DROP DATABASE lista4;

#może jakaś lepsza nazwa?
CREATE DATABASE lista4;

USE lista4;

# hasło po zhashowaniu bedzie varcharem???
CREATE TABLE uzytkownicy (
    login VARCHAR(30) PRIMARY KEY,
    haslo VARCHAR(30) NOT NULL,
    poziom_uprawnien ENUM('administrator', 'menadzer', 'sprzedawca') NOT NULL
);

CREATE TABLE logi (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    data DATETIME DEFAULT NOW(),
    uzytkownik VARCHAR(30) NOT NULL,
    opis_akcji VARCHAR(60) NOT NULL,
    FOREIGN KEY (uzytkownik) REFERENCES uzytkownicy(login)
);

#czy chcemy żeby data była automatycznie uzupełniana? i czy chcemy date czy date time?
CREATE TABLE rachunki (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    data DATETIME DEFAULT NOW(),
    uzytkownik VARCHAR(30) NOT NULL,
    FOREIGN KEY (uzytkownik) REFERENCES uzytkownicy(login)
);

CREATE TABLE przedmioty (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cena FLOAT NOT NULL,
    vat FLOAT NOT NULL,
    nazwa VARCHAR(30) NOT NULL
);

CREATE TABLE pozycje (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    przedmiot INT UNSIGNED,
    ilosc INT UNSIGNED NOT NULL,
    rabat FLOAT,
    FOREIGN KEY (przedmiot) REFERENCES przedmioty(id)
);

CREATE TABLE rachunki_pozycje (
    rachunek INT UNSIGNED,
    pozycja INT UNSIGNED,
    PRIMARY KEY (rachunek, pozycja),
    FOREIGN KEY (rachunek) REFERENCES rachunki(id),
    FOREIGN KEY (pozycja) REFERENCES pozycje(id)
);
