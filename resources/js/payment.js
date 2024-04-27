// Get DOM Elements
const form = document.getElementById('payment-form');
const submitBtn = form.querySelector('input[type="submit"]');

// Get data
const clientToken = form.dataset.token;
let paymentRequested = false;

// Init Braintree Dropin
braintree.dropin.create({
    authorization: clientToken,
    container: '#dropin-container'
}, (error, dropinInstance) => {
    // Gestione degli errori durante la creazione del Drop-in
    if (error) {
        console.error('Error creating Drop-in:', error);
        return;
    }

    // Event listener per la sottomissione del modulo
    form.addEventListener('submit', event => {
        event.preventDefault();

        // Blocco delle richieste di pagamento se già effettuate
        if (paymentRequested) return;

        // Impedire ulteriori sottomissioni
        paymentRequested = true;
        submitBtn.disabled = true;

        // Richiesta del metodo di pagamento (Nonce)
        dropinInstance.requestPaymentMethod((error, payload) => {
            // Gestione degli errori durante la richiesta del metodo di pagamento
            if (error) {
                console.error('Error requesting payment method:', error);
                // Ripristina lo stato del pulsante di invio
                paymentRequested = false;
                submitBtn.disabled = false;
                return;
            }

            // Imposta il valore del nonce nel campo nascosto del modulo
            document.getElementById('nonce').value = payload.nonce;

            // Invia il modulo
            form.submit();
        });
    });
});



document.addEventListener('DOMContentLoaded', function () {
    // Aggiungi un gestore di eventi click per catturare il clic sul pulsante di pagamento per ogni sponsor
    const paymentButtons = document.querySelectorAll('.payment-btn');
    paymentButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Ottieni l'ID dello sponsor dal pulsante
            const sponsorId = button.id.split('-')[1];
            // Imposta il valore del campo nascosto "sponsor" con l'ID dello sponsor selezionato
            document.getElementById('sponsor').value = sponsorId;
        });
    });
});

