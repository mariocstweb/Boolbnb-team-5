const deleteForms = document.querySelectorAll('.del-form');
const modal = document.getElementById('modal');
const modalTitle = document.querySelector('.modal-title');
const modalBody = document.querySelector('.modal-body');
const confirmationButton = document.getElementById('modal-confirmation-button');

let activeForm = null;

deleteForms.forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();

        activeForm = form;

        const apartmentTitle = form.dataset.apartment;

        // Inserisco il content
        confirmationButton.innerText = 'Conferma eliminazione';
        confirmationButton.className = 'btn btn-danger';
        modalTitle.innerText = 'Elimina appartamento';
        modalBody.innerText = `Sei sicuro di voler eliminare DEFINITIVAMENTE: "${apartmentTitle}"?`;
    })
})

confirmationButton.addEventListener('click', () => {
    if (activeForm) activeForm.submit();
});

modal.addEventListener('hidden.bs.modal', () => {
    activeForm = null;
})