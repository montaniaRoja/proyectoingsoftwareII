document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('show-edit-modal', () => {
        setTimeout(() => {
            const modalElement = document.getElementById('editUserModal');
            const editUserModal = bootstrap.Modal.getOrCreateInstance(modalElement);
            editUserModal.show();

            syncRolSelectWithInput(); // sincroniza al mostrar el modal
        }, 300);
    });

    Livewire.on('hide-edit-modal', () => {
        const modalElement = document.getElementById('editUserModal');
        const editUserModal = bootstrap.Modal.getOrCreateInstance(modalElement);
        editUserModal.hide();
    });
});

function syncRolSelectWithInput() {
    const inputRol = document.getElementById("rol");
    const selectRol = document.getElementById("rolSelect");

    if (!inputRol || !selectRol) return;

    // Al mostrar el modal, sincronizar valor del input en el select
    const currentRol = inputRol.value;
    if (currentRol) {
        selectRol.value = currentRol;
    } else {
        selectRol.selectedIndex = 0; // selecciona el primer elemento
    }

    // Si el usuario cambia el select, actualiza el input
    selectRol.addEventListener("change", function () {
        inputRol.value = this.value;
        inputRol.dispatchEvent(new Event('input', { bubbles: true }));
        console.log("Rol cambiado a:", this.value);
    });
}
