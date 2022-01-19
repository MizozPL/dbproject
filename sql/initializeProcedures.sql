USE db_project;

-- przedmiot
DELIMITER $$
DROP PROCEDURE IF EXISTS dodajPrzedmiot;
CREATE PROCEDURE dodajPrzedmiot(
    IN mCena DECIMAL(10, 2),
    IN mVat DECIMAL(2, 2),
    IN mNazwa VARCHAR(30)
)
BEGIN
    PREPARE dodajPrzedmiot_stm FROM 'INSERT INTO przedmioty (cena, vat, nazwa) VALUES (?, ?, ?)';
    EXECUTE dodajPrzedmiot_stm USING mCena, mVat, mNazwa;
    SELECT LAST_INSERT_ID() AS returnValue;
    DEALLOCATE PREPARE dodajPrzedmiot_stm;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS usunPrzedmiot;
CREATE PROCEDURE usunPrzedmiot(
    IN mId INT UNSIGNED
)
BEGIN
    PREPARE usunPrzedmiot_stm FROM 'DELETE FROM przedmioty WHERE id = ?';
    EXECUTE usunPrzedmiot_stm USING mId;
    SELECT ROW_COUNT() AS returnValue;
    DEALLOCATE PREPARE usunPrzedmiot_stm;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS edytujPrzedmiot;
CREATE PROCEDURE edytujPrzedmiot(
    IN mId INT UNSIGNED,
    IN mCena DECIMAL(10, 2),
    IN mVat DECIMAL(2, 2),
    IN mNazwa VARCHAR(30)
)
BEGIN
    PREPARE edytujPrzedmiot_stm FROM 'UPDATE przedmioty SET cena = ?, vat = ?, nazwa = ? WHERE id = ?';
    EXECUTE edytujPrzedmiot_stm USING mCena, mVat, mNazwa, mId;
    SELECT ROW_COUNT() AS returnValue;
    DEALLOCATE PREPARE edytujPrzedmiot_stm;
END$$
DELIMITER ;

-- pozycja
DELIMITER $$
DROP PROCEDURE IF EXISTS dodajPozycje;
CREATE PROCEDURE dodajPozycje(
    mPrzedmiot INT UNSIGNED,
    mIlosc INT UNSIGNED,
    mRabat DECIMAL(2, 2)
)
BEGIN
    PREPARE dodajPozycje_stm FROM 'INSERT INTO pozycje (przedmiot, ilosc, rabat) VALUES (?, ?, ?)';
    EXECUTE dodajPozycje_stm USING mPrzedmiot, mIlosc, mRabat;
    SELECT LAST_INSERT_ID() AS returnValue;
    DEALLOCATE PREPARE dodajPozycje_stm;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS usunPozycje;
CREATE PROCEDURE usunPozycje(
    IN mId INT UNSIGNED
)
BEGIN
    PREPARE usunPozycje_stm FROM 'DELETE FROM pozycje WHERE id = ?';
    EXECUTE usunPozycje_stm USING mId;
    SELECT ROW_COUNT() AS returnValue;
    DEALLOCATE PREPARE usunPozycje_stm;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS edytujPozycje;
CREATE PROCEDURE edytujPozycje(
    IN mId INT UNSIGNED,
    mPrzedmiot INT UNSIGNED,
    mIlosc INT UNSIGNED,
    mRabat DECIMAL(2, 2)
)
BEGIN
    PREPARE edytujPozycje_stm FROM 'UPDATE pozycje SET przedmiot = ?, ilosc = ?, rabat = ? WHERE id = ?';
    EXECUTE edytujPozycje_stm USING mPrzedmiot, mIlosc, mRabat, mId;
    SELECT ROW_COUNT() AS returnValue;
    DEALLOCATE PREPARE edytujPozycje_stm;
END$$
DELIMITER ;

-- rachunek
DELIMITER $$
DROP PROCEDURE IF EXISTS usunRachunek;
CREATE PROCEDURE usunRachunek(
    IN mId INT UNSIGNED
)
BEGIN
    PREPARE usunRachunek_stm FROM 'DELETE FROM rachunki WHERE id = ?';
    EXECUTE usunRachunek_stm USING mId;
    SELECT ROW_COUNT() AS returnValue;
    DEALLOCATE PREPARE usunRachunek_stm;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS dodajRachunek;
CREATE PROCEDURE dodajRachunek(
    IN mUzytkownik VARCHAR(30)
)
BEGIN
    PREPARE dodajRachunek_stm FROM 'INSERT INTO rachunki (uzytkownik) VALUES (?)';
    EXECUTE dodajRachunek_stm USING mUzytkownik;
    SELECT LAST_INSERT_ID() AS returnValue;
    DEALLOCATE PREPARE dodajRachunek_stm;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS usunPozycjeZRachunku;
CREATE PROCEDURE usunPozycjeZRachunku(
    IN mRachunek INT UNSIGNED,
    IN mPozycja INT UNSIGNED
)
BEGIN
    PREPARE usunPozycjeZRachunku_stm FROM 'DELETE FROM rachunki_pozycje WHERE rachunek = ? AND pozycja = ?';
    EXECUTE usunPozycjeZRachunku_stm USING mRachunek, mPozycja;
    SELECT ROW_COUNT() AS returnValue;
    DEALLOCATE PREPARE usunPozycjeZRachunku_stm;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS dodajPozycjeDoRachunku;
CREATE PROCEDURE dodajPozycjeDoRachunku(
    IN mRachunek INT UNSIGNED,
    IN mPozycja INT UNSIGNED
)
BEGIN
    PREPARE dodajPozycjeDoRachunku_stm FROM 'INSERT INTO rachunki_pozycje (rachunek, pozycja) VALUES (?, ?)';
    EXECUTE dodajPozycjeDoRachunku_stm USING mRachunek, mPozycja;
    DEALLOCATE PREPARE dodajPozycjeDoRachunku_stm;
END$$
DELIMITER ;

-- uzytkownicy
DELIMITER $$
DROP PROCEDURE IF EXISTS dodajUzytkownika;
CREATE PROCEDURE dodajUzytkownika(
    IN mLogin VARCHAR(30),
    IN mHaslo VARCHAR(30),
    IN mPoziom_uprawnien ENUM('administrator', 'menadzer', 'sprzedawca')
)
BEGIN
    PREPARE dodajUzytkownika_stm FROM 'INSERT INTO uzytkownicy (login, haslo, poziom_uprawnien) VALUES (?, ?, ?)';
    EXECUTE dodajUzytkownika_stm USING mLogin, mHaslo, mPoziom_uprawnien;
    DEALLOCATE PREPARE dodajUzytkownika_stm;
END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS usunUzytkownika;
CREATE PROCEDURE usunUzytkownika(
    IN mLogin VARCHAR(30)
)
BEGIN
    PREPARE usunUzytkownika_stm FROM 'DELETE FROM uzytkownicy WHERE login = ?';
    EXECUTE usunUzytkownika_stm USING mLogin;
    SELECT ROW_COUNT() AS returnValue;
    DEALLOCATE PREPARE usunUzytkownika_stm;
END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS edytujUzytkownika;
CREATE PROCEDURE edytujUzytkownika(
    IN mLogin VARCHAR(30),
    IN mHaslo VARCHAR(30),
    IN mPoziom_uprawnien ENUM('administrator', 'menadzer', 'sprzedawca')
)
BEGIN
    PREPARE edytujUzytkownika_stm FROM 'UPDATE uzytkownicy SET haslo = ?, poziom_uprawnien = ? WHERE login = ?';
    EXECUTE edytujUzytkownika_stm USING mHaslo, mPoziom_uprawnien, mLogin;
    SELECT ROW_COUNT() AS returnValue;
    DEALLOCATE PREPARE edytujUzytkownika_stm;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS listujUzytkownikow;
CREATE PROCEDURE listujUzytkownikow()
BEGIN
    SELECT login, poziom_uprawnien FROM uzytkownicy;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS zweryfikujHaslo;
CREATE PROCEDURE zweryfikujHaslo(
    IN mLogin VARCHAR(30),
    IN mHaslo VARCHAR(30)
)
BEGIN
    PREPARE zweryfikujHaslo_stm FROM 'SELECT poziom_uprawnien AS returnValue FROM uzytkownicy WHERE login = ? AND haslo = ?';
    EXECUTE zweryfikujHaslo_stm USING mLogin, mHaslo;
    DEALLOCATE PREPARE zweryfikujHaslo_stm;
END$$
DELIMITER ;

-- logi
DELIMITER $$
DROP PROCEDURE IF EXISTS wypiszLogi;
CREATE PROCEDURE wypiszLogi()
BEGIN
    SELECT * FROM logi;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS wyczyscLogi;
CREATE PROCEDURE wyczyscLogi()
BEGIN
    DELETE FROM logi;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS logujDane;
CREATE PROCEDURE logujDane(
    IN mUzytkownik VARCHAR(30),
    IN opis_akcji VARCHAR(60)
)
BEGIN
    PREPARE logujDane_stm FROM 'INSERT INTO logi (uzytkownik, opis_akcji) VALUES (?, ?)';
    EXECUTE logujDane_stm USING mUzytkownik, opis_akcji;
    DEALLOCATE PREPARE logujDane_stm;
END$$
DELIMITER ;

-- wypisywanie

DELIMITER $$
DROP PROCEDURE IF EXISTS wypiszPrzedmiot;
CREATE PROCEDURE wypiszPrzedmiot(
    IN mId INT UNSIGNED
)
BEGIN
    DECLARE lCena DECIMAL(10,2);
    DECLARE lVat DECIMAL(2,2);
    DECLARE lNazwa VARCHAR(30);
    DECLARE lExists INT;

    SET lExists = FALSE;

    -- nie musimy się martwić o sql injection - mamy tylko int'a
    SELECT TRUE INTO lExists FROM przedmioty WHERE id = mId;
    IF lExists THEN
        SELECT cena INTO lCena FROM przedmioty WHERE id = mId;
        SELECT vat INTO lVat FROM przedmioty WHERE id = mId;
        SELECT nazwa INTO lNazwa FROM przedmioty WHERE id = mId;
        SELECT CONCAT('ID: ', mId, ' CENA: ', lCena, ' VAT: ', lVat, ' NAZWA: ', lNazwa) AS returnValue;
    ELSE
        SELECT -1 AS returnValue;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS wypiszPozycje;
CREATE PROCEDURE wypiszPozycje(
    IN mId INT UNSIGNED
)
BEGIN
    DECLARE lPrzedmiot INT UNSIGNED;
    DECLARE lIlosc INT UNSIGNED;
    DECLARE lRabat DECIMAL(2,2);

    DECLARE lCena DECIMAL(10,2);
    DECLARE lVat DECIMAL(2,2);
    DECLARE lNazwa VARCHAR(30);

    DECLARE lExists INT;

    SET lExists = FALSE;

    -- nie musimy się martwić o sql injection - mamy tylko int'a
    SELECT TRUE INTO lExists FROM pozycje WHERE id = mId;
    IF lExists THEN
        SELECT przedmiot INTO lPrzedmiot FROM pozycje WHERE id = mId;
        SELECT ilosc INTO lIlosc FROM pozycje WHERE id = mId;
        SELECT rabat INTO lRabat FROM pozycje WHERE id = mId;

        SELECT cena INTO lCena FROM przedmioty WHERE id = lPrzedmiot;
        SELECT vat INTO lVat FROM przedmioty WHERE id = lPrzedmiot;
        SELECT nazwa INTO lNazwa FROM przedmioty WHERE id = lPrzedmiot;

        SELECT CONCAT('POZYCJA_ID: ', mId, ' PRZEDMIOT_ID: ', lPrzedmiot, ' NAZWA: ', lNazwa, ' ILOSC: ', lIlosc, ' RABAT: ', lRabat , ' NETTO: ', lCena * lIlosc, ' VAT: ', lVat, ' BRUTTO: ', lCena * lIlosc * (1+lVat), ' OSTATECZNIE: ', lCena * lIlosc * (1+lVat) * (1-lRabat)) AS returnValue;
    ELSE
        SELECT -1 AS returnValue;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS wypiszRachunek;
CREATE PROCEDURE wypiszRachunek(
    IN mId INT UNSIGNED
)
BEGIN
    DECLARE lData DATETIME;
    DECLARE lUzytkownik VARCHAR(30);
    DECLARE lPozycja INT UNSIGNED;

    DECLARE llIlosc INT UNSIGNED;
    DECLARE llRabat DECIMAL(2,2);
    DECLARE llPrzedmiot INT UNSIGNED;

    DECLARE llCena DECIMAL(10,2);
    DECLARE llVat DECIMAL(2,2);
    DECLARE llNazwa VARCHAR(30);

    DECLARE lDone INT;
    DECLARE lBuffer MEDIUMTEXT;
    DECLARE lExists INT;

    DECLARE lCursor CURSOR FOR (SELECT pozycja FROM rachunki_pozycje WHERE rachunek = mId);
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET lDone = TRUE;

    SET lExists = FALSE;
    SET lDone = FALSE;

    -- nie musimy się martwić o sql injection - mamy tylko int'a
    SELECT TRUE INTO lExists FROM rachunki WHERE id = mId;
    IF lExists THEN

        SELECT data INTO lData FROM rachunki WHERE id = mId;
        SELECT uzytkownik INTO lUzytkownik FROM rachunki WHERE id = mId;

        SELECT CONCAT('RACHUNEK_ID: ', mID, ' DATA: ', lData, ' UZYTKOWNIK: ', lUzytkownik, '\n\n') INTO lBuffer;

        OPEN lCursor;

        read_loop: LOOP
            FETCH lCursor INTO lPozycja;

            if lDone THEN
                leave read_loop;
            END IF;

            SELECT ilosc INTO llIlosc FROM pozycje WHERE id = lPozycja;
            SELECT rabat INTO llRabat FROM pozycje WHERE id = lPozycja;
            SELECT przedmiot INTO llPrzedmiot FROM pozycje WHERE id = lPozycja;

            SELECT cena INTO llCena FROM przedmioty WHERE id = llPrzedmiot;
            SELECT vat INTO llVat FROM przedmioty WHERE id = llPrzedmiot;
            SELECT nazwa INTO llNazwa FROM przedmioty WHERE id = llPrzedmiot;

            SELECT CONCAT(lBuffer, 'POZYCJA_ID: ', lPozycja, ' PRZEDMIOT_ID: ', llPrzedmiot, ' NAZWA: ', llNazwa, ' ILOSC: ', llIlosc , ' RABAT: ', llRabat , ' NETTO: ', llCena * llIlosc, ' VAT: ', llVat, ' BRUTTO: ', llCena * llIlosc * (1+llVat) , ' OSTATECZNIE: ', llCena * llIlosc * (1+llVat) * (1-llRabat), '\n') INTO lBuffer;
        END LOOP;

        CLOSE lCursor;

        SELECT lBuffer AS returnValue;
    ELSE
        SELECT -1 AS returnValue;
    END IF;
END$$
DELIMITER ;