1) W tabeli logi zapisujemy logi, ale tylko te z poziomu php. To znaczy php wywołuje procedurę addLog() z sql'a. Natomiast procedury z sql'a nie logują do tej tabeli. Od tego służy log mysql'a


2) PhpStorm ma jakiś bug z procedurami... Np. jak wywołujesz
call edytujPozycje(3, 1, 11, 0.11);
dwa razy z rzędu to cały czas zwraca 1, mimo tego, że nie zostało nic zaktualizowane.
Konsola i php zwracają zero

3)Należy zrobić sesję logowania php  i sprawdzać po stronie php uprawnienia użytkownika, potem includować odpowiedni header userLevel, managerLevel lub adminLevel i wykonać operację...
https://makitweb.com/create-simple-login-page-with-php-and-mysql/