<nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky py-4 px-3 sidebar-sticky">
        <ul class="nav flex-column h-100">
            <!-- Clientes con submenú -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#clientesSubmenu" role="button" aria-expanded="false" aria-controls="clientesSubmenu">
                    <span>
                        <i class="bi-house-fill me-2"></i>
                        Clientes
                    </span>
                    <i class="bi-caret-down-fill"></i>
                </a>
                <div class="collapse ps-4" id="clientesSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('customers')}}">Todos los Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Crear Empresas</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Otros ítems -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#transaccionesSubmenu" role="button" aria-expanded="false" aria-controls="clientesSubmenu">
                    <span>
                        <i class="bi-house-fill me-2"></i>
                        Transacciones
                    </span>
                    <i class="bi-caret-down-fill"></i>
                </a>
                <div class="collapse ps-4" id="transaccionesSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Depositos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Retiros</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#administracionSubmenu" role="button" aria-expanded="false" aria-controls="clientesSubmenu">
                    <span>
                        <i class="bi-house-fill me-2"></i>
                        Administrador
                    </span>
                    <i class="bi-caret-down-fill"></i>
                </a>
                <div class="collapse ps-4" id="administracionSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Roles</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#reportesSubmenu" role="button" aria-expanded="false" aria-controls="clientesSubmenu">
                    <span>
                        <i class="bi-house-fill me-2"></i>
                        Reportes
                    </span>
                    <i class="bi-caret-down-fill"></i>
                </a>
                <div class="collapse ps-4" id="reportesSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Depositos Totales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Estado de Cuenta</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item border-top mt-auto pt-2">
                <a class="nav-link" href="{{route('user.logout')}}">
                    <i class="bi-box-arrow-left me-2"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
