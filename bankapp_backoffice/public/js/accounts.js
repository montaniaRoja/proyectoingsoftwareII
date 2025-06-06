document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('show-account-modal', () => {

        var accountModal = new bootstrap.Modal(document.getElementById('accountModal'));
        configSelect();
        generateAccount();
        accountModal.show();

    });

    Livewire.on('show-transaction-modal', () => {

        var transactionModal = new bootstrap.Modal(document.getElementById('transactionModal'));
        configSelect();
        transactionModal.show();

    });

    Livewire.on('show-transactions-modal', () => {

        var transactionsModal = new bootstrap.Modal(document.getElementById('transactionsModal'));

        transactionsModal.show();

    });

    Livewire.on('hide-transactions-modal', () => {

        var transactionsModal = new bootstrap.Modal(document.getElementById('transactionsModal'));

        transactionsModal.hide();
        removeBackdrop();

    });

    Livewire.on('hide-account-modal', () => {
        let accountModal = new bootstrap.Modal(document.getElementById("accountModal"));

        accountModal.hide();
        removeBackdrop();
    });

    Livewire.on('hide-transaction-modal', () => {
        let transactionModal = new bootstrap.Modal(document.getElementById("transactionModal"));

        transactionModal.hide();
        removeBackdrop();
    });
});

function configSelect() {
    let monedaSelect = document.getElementById('selectorMoneda');
    let transaccionSelect = document.getElementById('selectorTransaccion');

    monedaSelect.value = "";
    monedaSelect.dispatchEvent(new Event('change'));
    monedaSelect.addEventListener('change', function () {
        let value = $(this).val();
        let monedaInput = document.getElementById('moneda');
        monedaInput.value = value;
        monedaInput.dispatchEvent(new Event('input'));
    });

    transaccionSelect.value = "";
    transaccionSelect.dispatchEvent(new Event('change'));
    transaccionSelect.addEventListener('change', function () {
        let value = $(this).val();
        let transaccionInput = document.getElementById('transaccion');
        transaccionInput.value = value;
        transaccionInput.dispatchEvent(new Event('input'));
    });
}

function generateAccount() {
    const fecha = new Date();
    const dia = fecha.getDate();
    const mes = fecha.getMonth() + 1; // Los meses en Date van de 0 a 11, por eso sumamos 1
    const anio = fecha.getFullYear();
    const minuto = fecha.getMinutes();
    const segundo = fecha.getSeconds();
    const hora = fecha.getHours() + 10;

    let accountNumber = `${anio}${mes}${dia}${hora}${minuto}${segundo}`;

    if (mes > 9 && dia < 10) {
        accountNumber = `${anio}${mes}0${dia}${hora}${minuto}${segundo}`;
    }
    if (mes < 10 && dia < 10) {
        accountNumber = `${anio}0${mes}0${dia}${hora}${minuto}${segundo}`;
    }
    if (mes < 10 && dia > 9) {
        accountNumber = `${anio}0${mes}${dia}${hora}${minuto}${segundo}`;
    }

    document.getElementById('cuenta').value = accountNumber;
    document.getElementById('cuenta').dispatchEvent(new Event('input'));

}

function removeBackdrop(){
     var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove(); // Elimina el backdrop
        }
}
