/* RECUEPRO FORM */
const form = document.getElementById('payment-form');
/* RECUEPRO BOTTONE PAGA */
const submitBtn = document.querySelector('.input-submit');


/* RECUEPRO IL VALORE DELL'ALTTRIBUTO DATA-TOKEN PER AUTORIZZAZZIONE DEL PAGAMENTO */
const clientToken = form.dataset.token;

/* VARIBILE DA MANIPOLARE PER CONTROLLARE SE LA RICHIESTA DEL PAGAMENTO E' GIA STATA FATTA */
let paymentRequested = false;


/* INIZIALIZZAZZIONE DEL COMPINENTE DROP-IN DI BRAINTREE */
braintree.dropin.create({
    authorization: clientToken, // AUTORIZZIONE TRAMITE IL TOKEN
    container: '#dropin-container' // CONTENITORE DOVE INSERIRE IL DROP-IN


}, (error, dropinInstance) => {

    /* CONTROLLO ERRORI DURANTE LA CREZIONE DEL DROP-IN */
    if (error) {

        /* MESSAGGIO ERRORE */
        console.error('Error creating Drop-in:', error);
        return;
    }

    /* EVENTO AL FORM  */
    form.addEventListener('submit', event => {


        /* BLOCCO COMPORTAMENTO DI DAFAULT */
        event.preventDefault();


        /* SE ESISTE GIA' UNA RICHIESTA DI PAGAMENTO BLOCCA TUTTO */
        if (paymentRequested) return;


        /* IMPOSTO LA VARIBILE A TRUE PER BLOCCARE ULTERIORI RICHIESTE */
        paymentRequested = true;


        /* DISABILITO BOTTONE PER PREVENIRE ULTERIORI RICHIESTE */
        submitBtn.disabled = true;


        /* RUCHIEDO METODO DI PAGAMENTO DA BRAINTREE (NONCE) */
        dropinInstance.requestPaymentMethod((error, payload) => {


            /* CONTROLLO SE CI SONO ERRORI DURANTE LA RICHIESTA */
            if (error) {

                /* MESSAGGIO DI ERRORE */
                console.error('Error requesting payment method:', error);

                /* RIPRISTINO LO STATO INIZIALE IN CASO DI ERRORE */
                paymentRequested = false;
                submitBtn.disabled = false;
                return;
            }


            /* ASSEGNO IL VARORE DEL NONCE (TOKEN) AL CAMPO INPUT NASCOSTO */
            document.getElementById('nonce').value = payload.nonce;


            /* INVIO IL MODULO PER IL PAGAMENTO */
            form.submit();
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const sponsorRadios = document.querySelectorAll('input[name="sponsor"]');
    const expirationDateElement = document.getElementById('expiration-date');

    sponsorRadios.forEach(function(radio) {
        radio.addEventListener("change", function() {
            const selectedDuration = parseInt(this.dataset.duration); // Durata selezionata
            const expirationDate = new Date(); // Data di oggi
            expirationDate.setHours(expirationDate.getHours() + selectedDuration); // Aggiorna la data di scadenza
            expirationDateElement.textContent = expirationDate.toLocaleString(); // Aggiorna la visualizzazione della data di scadenza
        });
    });
});



