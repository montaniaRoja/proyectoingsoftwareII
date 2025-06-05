document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('show-account-modal', () => {

        var accountModal = new bootstrap.Modal(document.getElementById('accountModal'));
        configSelect();
        generateAccount();
        accountModal.show();

    });

    Livewire.on('hide-account-modal', () => {
        let accountModal = new bootstrap.Modal(document.getElementById("accountModal"));

        accountModal.hide();
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove(); // Elimina el backdrop
        }
    });
});

function configSelect() {
    let monedaSelect = document.getElementById('selectorMoneda');
    monedaSelect.addEventListener('change', function () {
        let selectId = $(this).attr('id');
        let value = $(this).val();

        if (selectId === 'selectorMoneda') {
            console.log('selecto moneda');
            let monedaInput = document.getElementById('moneda');
            monedaInput.value = value;
            monedaInput.dispatchEvent(new Event('input'));
        }
    });
}

function generateAccount() {
    const fecha = new Date();
    const dia = fecha.getDate();
    const mes = fecha.getMonth() + 1; // Los meses en Date van de 0 a 11, por eso sumamos 1
    const anio = fecha.getFullYear();
    const minuto=fecha.getMinutes();
    const segundo=fecha.getSeconds();

    let accountNumber=`${anio}${mes}${dia}${minuto}${segundo}`;

    if(mes>9 && dia<10){
        accountNumber=`${anio}${mes}0${dia}${minuto}${segundo}`;
    }
    if(mes<10 && dia<10){
        accountNumber=`${anio}0${mes}0${dia}${minuto}${segundo}`;
    }
    if(mes<10 && dia>9){
        accountNumber=`${anio}0${mes}${dia}${minuto}${segundo}`;
    }

    document.getElementById('cuenta').value=accountNumber;
    document.getElementById('cuenta').dispatchEvent(new Event('input'));

}
