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

        // Corrige el scroll del body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';

    });

    Livewire.on('show-editcustomer-modal', () => {
        setTimeout(() => {
            const modalElement = document.getElementById('editCustomerModal');
            const editCustomerModal = bootstrap.Modal.getOrCreateInstance(modalElement);
            editCustomerModal.show();
        }, 10);
    });

    Livewire.on('hide-editcustomer-modal', () => {
        const modalElement = document.getElementById("editCustomerModal");
        const editCustomerModal = bootstrap.Modal.getInstance(modalElement);
        if (editCustomerModal) {
            editCustomerModal.hide();
        }

        // Espera a que el modal se oculte para limpiar si hace falta
        setTimeout(() => {
            // A veces Bootstrap no limpia el backdrop por alguna razón
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            // Asegura que el scroll se restaure
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
        }, 300); // Da tiempo a la animación de cierre
    });



});
