<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li @click="menu=14" class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i> <b>Escritorio</b></a>
            </li>
            <li class="nav-title" style="color:#ff671b">
                Mantenimiento
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-settings"></i> <b>Documentación</b></a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{asset('files/Administrador.pdf')}}" target='new'><i class="icon-book-open"></i> Manual de usuario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://drive.google.com/file/d/1Ej8SepafEu9aHtpbKP3geo5k0MD4KCnU/view" target='new'><i class="icon-book-open"></i> Cartilla</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://indd.adobe.com/view/b13edd50-af60-4404-a80d-42cd84e81ab1" target='new'><i class="icon-book-open"></i> Cartilla digital</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-settings"></i> <b>Administración</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=17" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Configuración</a>
                    </li>
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Areas</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Procesos</a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Perfiles</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-folder"></i> <b>Conceptos cif</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=10" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-folder-alt"></i> Conceptos</a>
                    </li>
                    <li @click="menu=11" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-folder-alt"></i> Maquinaria</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wrench"></i> <b>Materiales</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Unidades</a>
                    </li>
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Clasificación</a>
                    </li>
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Materias primas</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> <b>Productos</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Colecciones</a>
                    </li>
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Productos</a>
                    </li>
                    <li @click="menu=9" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Hojas de costo</a>
                    </li>
                    <li @click="menu=18" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Simulador</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-docs"></i> <b>Producción</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=22" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-doc"></i> Cotización</a>
                    </li>
                    <li @click="menu=23" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-doc"></i> Orden de pedido</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-folder-alt"></i> <b>Kárdex</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=24" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-note"></i> Kárdex almacén</a>
                    </li>
                    <li @click="menu=26" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-note"></i> Toma inventario</a>
                    </li>
                    <li @click="menu=25" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-note"></i> Kárdex producto</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i> <b>Personas</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=12" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-pencil"></i> Roles</a>
                    </li>
                    <li @click="menu=13" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-pencil"></i> Usuarios</a>
                    </li>
                    <li @click="menu=19" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-pencil"></i> Proveedores</a>
                    </li>
                    <li @click="menu=20" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-pencil"></i> Clientes</a>
                    </li>
                    <li @click="menu=21" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-pencil"></i> Empleados</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
