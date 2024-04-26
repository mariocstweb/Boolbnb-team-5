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

    // Creation Error
    if (error) console.error(error);

    // Submit Event
    form.addEventListener('submit', event => {
        event.preventDefault();

        // Block other payments request if already done
        if (paymentRequested) return;

        // Prevent other submit
        paymentRequested = true;
        submitBtn.disabled = true;

        // Send Nonce Token Request
        dropinInstance.requestPaymentMethod((error, payload) => {

            // Payment Error
            if (error) console.error(error);

            // Set Nonce Token Input
            document.getElementById('nonce').value = payload.nonce;

            form.submit();
        });
    });
});

