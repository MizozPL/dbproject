let id_przedmiotow = [];
let rachunek;

function dodajPozycje() {
    let select = document.getElementById("przedmioty");
    let przedmiot = select.value;
    let nazwaPrzedmiotu = select.options[select.selectedIndex].text;

    if(!id_przedmiotow.includes(przedmiot)){
        id_przedmiotow.push(przedmiot);

        let conteiner = document.getElementById("listaPozycji");

        var div = document.createElement('DIV');
        div.innerHTML += "<p>" + nazwaPrzedmiotu + " <input class='ilosc' type='number' min='1' step='1' value='1' placeholder='ilość'>" +
            "<input class='rabat' type='number' min='0' step='0.01' max='0.99' value='0' placeholder='rabat'></p>"
        conteiner.appendChild(div);
    }
}

function wyczysc(){
    id_przedmiotow = [];
    let conteiner = document.getElementById("listaPozycji");
    conteiner.innerHTML = "";
}

function zatwierdz(){
    let ilosci = document.getElementsByClassName('ilosc');
    let rabaty = document.getElementsByClassName('rabat');

    let tempIlosci = [];
    let tempRabaty = [];
    for(let i = 0; i < ilosci.length; i++) {
        tempIlosci[i] = ilosci[i].value;
        tempRabaty[i] = rabaty[i].value;
    }

    let outIDs = JSON.stringify(id_przedmiotow);
    let outIlosci = JSON.stringify(tempIlosci);
    let outRabaty = JSON.stringify(tempRabaty);

    fetch("../api/dodajCalyRachunekV3.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: `ids=${outIDs}&ilosci=${outIlosci}&rabaty=${outRabaty}`,
    }).then((response) => response.text()).then((res) => (
        document.getElementById('return').innerText=res));
}