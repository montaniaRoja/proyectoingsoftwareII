document.addEventListener('DOMContentLoaded', function () {
    new DataTable('#mainTable', {
        responsive: true
    });

    new DataTable('#grantedRolesTbl', {
        responsive: true
    });

    Livewire.on('hide-rol-modal', () => {
        const modalElement = document.getElementById("rolModal");
        const rolModal = bootstrap.Modal.getOrCreateInstance(modalElement);
        document.getElementById('rolId').value = '';

        document.getElementById('rolName').value = '';

        rolModal.hide();

        setTimeout(() => {
            $('#mainTable').DataTable().draw(false);
        }, 10);
    });

    Livewire.on('show-edit-modal', () => {
        setTimeout(() => {
            const modalElement = document.getElementById('rolModal');
            const rolModal = bootstrap.Modal.getOrCreateInstance(modalElement);
            $(document).ready(function () {

            });
            permissions = JSON.parse(document.getElementById('permissions').value);
            grantedPermissions = JSON.parse(document.getElementById('grantedPermissions').value);

            llenarTabla();
            rolModal.show();
        }, 10);
    });

    Livewire.on('show-rol-modal', () => {
        setTimeout(() => {
            var rolModal = new bootstrap.Modal(document.getElementById('rolModal'));
            $(document).ready(function () {

            });
            permissions = JSON.parse(document.getElementById('permissions').value);
            llenarTabla();
            rolModal.show();
        }, 10);
    });

});

var tablaDetalle;
var permissions = [];
var grantedPermissions = [];

function llenarTabla() {
    const tabla = $('#grantedRolesTbl');

    // Destruye DataTable si ya fue inicializado
    if ($.fn.DataTable.isDataTable('#grantedRolesTbl')) {
        tabla.DataTable().clear().destroy();
    }

    let tbody = tabla.find('tbody');
    tbody.html('');

    permissions.forEach((permission, i) => {
        let fila = `
            <tr id="fila-${i}">
                <td>${permission.id}</td>
                <td>${permission.name}</td>
                <td>
                    <input type="checkbox" class="form-check-input" data-add="${i}" ${permission.is_granted == 1 ? 'checked' : ''}>
                </td>
            </tr>
        `;
        tbody.append(fila);
    });

    // Volver a enlazar los eventos a los checkboxes
    tabla.find('input[type="checkbox"]').on('change', function () {
        const indice = $(this).data('add');
        const permission = permissions[indice];

        if (this.checked) {
            grantedPermissions.push({ grantedPermissionId: permission.id });
        } else {
            grantedPermissions = grantedPermissions.filter(item => item.grantedPermissionId !== permission.id);
        }

        document.getElementById('grantedPermissions').value = JSON.stringify(grantedPermissions);
        document.getElementById('grantedPermissions').dispatchEvent(new Event('input'));
    });

    // Re-inicializa el DataTable después de poblarlo
    tabla.DataTable({
        responsive: true,
        pageLength: 10, // opcional
        lengthChange: false, // opcional
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
        }
    });
}


function createCheckElement(is_granted) {
    var checkElement = document.createElement("input");
    checkElement.type = "checkbox";
    checkElement.id = "granted";
    checkElement.classList.add("form-check-input");
    if (is_granted === 1) {
        checkElement.checked = true;
    } else {
        checkElement.checked = false;
    }
    return checkElement;
}


