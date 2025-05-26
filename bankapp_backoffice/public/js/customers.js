document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('show-customer-modal', () => {
        setTimeout(() => {
            var customerModal = new bootstrap.Modal(document.getElementById('customerModal'));
            customerModal.show();
        }, 10);
    });

    Livewire.on('hide-customer-modal', () => {
        let customerModal = new bootstrap.Modal(document.getElementById("customerModal"));

        customerModal.hide();
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove(); // Elimina el backdrop
        }

    });


});
