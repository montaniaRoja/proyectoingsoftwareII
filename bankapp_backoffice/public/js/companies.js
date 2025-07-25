document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('show-company-modal', () => {
        setTimeout(() => {
            var companyModal = new bootstrap.Modal(document.getElementById('companyModal'));
            companyModal.show();
        }, 10);
    });

    Livewire.on('hide-company-modal', () => {
        let companyModal = new bootstrap.Modal(document.getElementById("companyModal"));

        companyModal.hide();
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove(); // Elimina el backdrop
        }

    });

     Livewire.on('show-payment-modal', () => {
        setTimeout(() => {
            var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();

        }, 10);
        console.log(document.getElementById('company_id').value);
    });

    Livewire.on('hide-payment-modal', () => {
        let paymentModal = new bootstrap.Modal(document.getElementById("paymentModal"));

        document.getElementById('clavecontrato').value='';
        document.getElementById('montocontrato').value='';

        paymentModal.hide();
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove(); // Elimina el backdrop
        }

    });


});
