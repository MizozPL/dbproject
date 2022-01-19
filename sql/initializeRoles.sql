USE db_project;

CREATE USER 'sprzedawca'@'localhost' IDENTIFIED BY 'zuRZEwn4t9h8FZzJ89iZJSd7EdQ3vkdd';

GRANT EXECUTE ON PROCEDURE dodajPrzedmiot TO 'sprzedawca'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajPozycje TO 'sprzedawca'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajRachunek TO 'sprzedawca'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajPozycjeDoRachunku TO 'sprzedawca'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszPozycje TO 'sprzedawca'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszPrzedmiot TO 'sprzedawca'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszRachunek TO 'sprzedawca'@'localhost';
GRANT EXECUTE ON PROCEDURE zweryfikujHaslo TO 'sprzedawca'@'localhost';
GRANT EXECUTE ON PROCEDURE logujDane TO 'sprzedawca'@'localhost';
GRANT SELECT ON TABLE przedmioty TO 'sprzedawca'@'localhost';
GRANT SELECT ON TABLE pozycje TO 'sprzedawca'@'localhost';
GRANT SELECT ON TABLE rachunki TO 'sprzedawca'@'localhost';
GRANT SELECT ON TABLE rachunki_pozycje TO 'sprzedawca'@'localhost';

CREATE USER 'menadzer'@'localhost' IDENTIFIED BY 'FyBfFAbiWQxKrfnR43feDhLDm4rGdXKN';

GRANT EXECUTE ON PROCEDURE dodajPrzedmiot TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajPozycje TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajRachunek TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajPozycjeDoRachunku TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszPozycje TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszPrzedmiot TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszRachunek TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE zweryfikujHaslo TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE logujDane TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE usunPrzedmiot TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE edytujPrzedmiot TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE usunPozycje TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE edytujPozycje TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE usunRachunek TO 'menadzer'@'localhost';
GRANT EXECUTE ON PROCEDURE usunPozycjeZRachunku TO 'menadzer'@'localhost';
GRANT SELECT ON TABLE przedmioty TO 'menadzer'@'localhost';
GRANT SELECT ON TABLE pozycje TO 'menadzer'@'localhost';
GRANT SELECT ON TABLE rachunki TO 'menadzer'@'localhost';
GRANT SELECT ON TABLE rachunki_pozycje TO 'menadzer'@'localhost';

CREATE USER 'administrator'@'localhost' IDENTIFIED BY 'AtjjD5zvfebP2pfJxkUkJNfbfNsnCxPN';

GRANT EXECUTE ON PROCEDURE dodajPrzedmiot TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajPozycje TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajRachunek TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajPozycjeDoRachunku TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszPozycje TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszPrzedmiot TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszRachunek TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE zweryfikujHaslo TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE logujDane TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE usunPrzedmiot TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE edytujPrzedmiot TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE usunPozycje TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE edytujPozycje TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE usunRachunek TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE usunPozycjeZRachunku TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE dodajUzytkownika TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE usunUzytkownika TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE edytujUzytkownika TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE listujUzytkownikow TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE wyczyscLogi TO 'administrator'@'localhost';
GRANT EXECUTE ON PROCEDURE wypiszLogi TO 'administrator'@'localhost';
GRANT SELECT ON TABLE przedmioty TO 'administrator'@'localhost';
GRANT SELECT ON TABLE pozycje TO 'administrator'@'localhost';
GRANT SELECT ON TABLE rachunki TO 'administrator'@'localhost';
GRANT SELECT ON TABLE rachunki_pozycje TO 'administrator'@'localhost';

-- admin:admin
INSERT INTO uzytkownicy(login, haslo, poziom_uprawnien) VALUE ('admin', '$argon2id$v=19$m=65536,t=4,p=1$cmNFekk5MUJTLzNaekxFcQ$6TwpnaHKEYbkIrNsHIXrAbeA2Zb/RbVcKSnmg/DhH/M', 'administrator');