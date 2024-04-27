/* RECUPERO BOTTONI */
const button1 = document.getElementById("button-1");
const button2 = document.getElementById("button-2");
const button3 = document.getElementById("button-3");
/* RECUEPRO CHECK RADIO */
const promoRadio1 = document.getElementById('sponsor-1');
const promoRadio2 = document.getElementById('sponsor-2');
const promoRadio3 = document.getElementById('sponsor-3');


/* EVENTO AL BOTTONE SULLA CARD BRONZE */
button1.addEventListener('click', () => {
    promoRadio1.checked = true;
    promoRadio2.checked = false;
    promoRadio3.checked = false;
});


/* EVENTO AL BOTTONE SULLA CARD SILVER */
button2.addEventListener('click', () => {
    promoRadio1.checked = false;
    promoRadio2.checked = true;
    promoRadio3.checked = false;
});


/* EVENTO AL BOTTONE SULLA CARD GOLD */
button3.addEventListener('click', () => {
    promoRadio1.checked = false;
    promoRadio2.checked = false;
    promoRadio3.checked = true;
});
