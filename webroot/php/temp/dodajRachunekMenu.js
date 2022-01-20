let id_przedmiotow = [];
let rachunek;

function dodajPozycje() {
    let select = document.getElementById("przedmioty");
    let przedmiot = select.value;
    let nazwaPrzedmiotu = select.options[select.selectedIndex].text;

    if(!id_przedmiotow.includes(przedmiot)){
        id_przedmiotow.push(przedmiot);

        let conteiner = document.getElementById("listaPozycji");

        conteiner.innerHTML += "<p>" + nazwaPrzedmiotu + " <input class='ilosc' type='number' min='1' step='1' value='1' placeholder='ilość'>" +
            "<input class='rabat' type='number' min='0' step='0.01' max='0.99' value='0' placeholder='rabat'></p>"
    }
}

function wyczysc(){
    id_przedmiotow = [];
    let conteiner = document.getElementById("listaPozycji");
    conteiner.innerHTML = "";
}

function zatwierdz(){

    //utwórz rachunek

    fetch("http://localhost:63342/dbproject/webroot/php/temp/newRachunek.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: ``,
    })
        .then((response) => response.text())
        .then((res) => (rachunek = res)

        );

    let pozycje = [];

    //dodaj pozycje
    let ilosci = document.getElementsByClassName('ilosc');
    let rabaty = document.getElementsByClassName('rabat');

    for (const i in id_przedmiotow) {

        let id = id_przedmiotow[i];
        let ilosc = ilosci[i].value;
        let rabat = rabaty[i].value;



        fetch("http://localhost:63342/dbproject/webroot/php/temp/addPozycja.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
            },
            body: `id=${id}&ilosc=${ilosc}&rabat=${rabat}`,
        })
            .then((response) => response.text())
            .then((res) => (link(res)));

    }

}

function link(pozycja){



    fetch("http://localhost:63342/dbproject/webroot/php/temp/linkPozycje.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: `pozycja=${pozycja}&rachunek=${rachunek}`,
    })
        .then((response) => response.text())
        .then((res) => (console.log(res)));

}