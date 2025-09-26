<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Contingencias</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
</head>

<body class="login-register">

<div class="spa-container">

    <!-- Login -->
    <div id="login-page" class="auth-page">
        <h2>Iniciar Sesión</h2>
        <form id="login-form">
            <input type="text" id="login-username" placeholder="Nombre de usuario" required>
            <input type="password" id="login-password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <p>¿No tienes cuenta? <span id="go-register">Regístrate</span></p>
    </div>

    <!-- Registro -->
    <div id="register-page" class="auth-page" style="display:none;">
        <h2>Registro</h2>
        <form id="register-form">
            <input type="text" id="register-fullname" placeholder="Nombre completo" required>
            <input type="text" id="register-username" placeholder="Nombre de usuario" required>
            <input type="password" id="register-password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <span id="go-login">Inicia sesión</span></p>
    </div>

    <!-- Main Page -->
    <div id="main-page" style="display:none;">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Menú</h2>
            <a href="#" class="menu-item active" data-section="inicio"><i class="fas fa-home"></i> Inicio</a>
            <a href="#" class="menu-item" data-section="usuarios"><i class="fas fa-users"></i> Usuarios</a>
            <a href="#" class="menu-item" data-section="profile-section"><i class="fas fa-user"></i> Perfil</a>
            <a href="#" class="menu-item" data-section="recursos"><i class="fas fa-boxes"></i> Recursos</a>
            <a href="#" class="menu-item" data-section="siniestros"><i class="fa-solid fa-skull-crossbones"></i>
                Siniestros</a>
        </div>

        <!-- Contenido principal -->
        <div class="main-content">
            <div class="topbar">
                <div >
                    <button id="btn-logout" class="kill-btn"><i class="fa-solid fa-right-from-bracket"></i></button>
                </div>
            </div>

            <!-- Sección Inicio activa por defecto -->
            <div class="section active" id="inicio">
                <div class="posts"></div>
            </div>

            <div class="section" id="siniestros">
                <button id="btn-new-siniestro">
                    <i class="fa-solid fa-plus"></i>
                    Crear
                </button>
                <table id="siniestros-table" class="tabla" border="1" style="width:100%; margin-top:10px;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ubicación</th>
                        <th>Nivel</th>
                        <th>Fecha/Hora</th>
                        <th>Recursos</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="section" id="usuarios">
                <table id="usuarios-table" class="tabla" border="1" style="width:100%; margin-top:10px;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Administrador</th>
                        <th>Sinestro</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="section" id="recursos">
                <table id="recursos-table" class="tabla" border="1" style="width:100%; margin-top:10px;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Usuario</th>
                        <th>Siniestro</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- Perfil -->
            <div id="profile-section" class="section">
                <div class="perfil">
                    <div class="profile">

                    </div>
                    <!-- Info -->
                    <div class="info">
                        <h3>Insignias</h3>
                        <div class="badges">
                            <img src="img/flamita.png" alt="Flamita">
                            <img src="img/Novato.png" alt="Novato apaga fuegos">
                            <img src="img/Exp_apg_f.png" alt="Experto apaga fuegos">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div id="modal-recursos" class="modal">
            <div class="modal-content">
                <h3>Nuevos recursos</h3>
                <form id="recursos-form">
                    <input type="hidden" id="recursos_id">
                    <input type="hidden" id="siniestro_id" value="">

                    <input type="text" id="name" placeholder="Nombre del recurso" required>
                    <input type="text" id="description" placeholder="Descripcion" required>
                    <label>Categoría</label>
                    <select name="category" id="category" required>
                        <option value="consumible">Consumible</option>
                        <option value="material">Material</option>
                    </select>

                    <input type="number" id="cantidad" placeholder="Cantidad de recursos" required>

                    <button type="submit">Guardar</button>
                    <button type="button" id="cerrar-modal-recursos">Cancelar</button>
                </form>
            </div>
        </div>

        <!-- Modal Crear Siniestro -->
        <div id="modal-siniestro" class="modal">
            <div class="modal-content">
                <h3>Nuevo Siniestro</h3>
                <form id="siniestro-form">
                    <input type="hidden" id="siniestro_id">
                    <input type="text" id="location" placeholder="Ubicación" required>
                    <input type="number" id="level" placeholder="Nivel (ej. 1,2,3)" required>
                    <input type="datetime-local" id="date_time" required>
                    <input type="text" id="resources" placeholder="Recursos necesarios" required>
                    <label>Activo: </label>
                    <input type="checkbox" id="active" checked>
                    <button type="submit">Guardar</button>
                    <button type="button" id="cerrar-modal">Cancelar</button>
                </form>
            </div>
        </div>

        <!-- Modal editar usuarios -->
        <div id="modal-usuarios" class="modal">
            <div class="modal-content">
                <h3>Editar usuario</h3>
                <form id="usuario-form">
                    <input type="hidden" id="usuario_id">
                    <input type="text" id="fullname" placeholder="Nombre completo" required>
                    <input type="text" id="username" placeholder="Nombre de usuario" required>
                    <input type="password" id="password" placeholder="Contraseña">
                    <label>Administrador: </label>
                    <input type="checkbox" id="is_admin" checked>
                    <button type="submit">Guardar</button>
                    <button type="button" id="cerrar-modal-usuarios">Cancelar</button>
                </form>
            </div>
        </div>

        <div id="confirmSiniestroDeleteDialog" title="Confirmar eliminación" style="display:none;">
            <p>
                <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
                ¿Seguro que deseas eliminar este siniestro? Esta acción no se puede deshacer ⚠️
            </p>
        </div>

        <div id="confirmUsuarioDeleteDialog" title="Confirmar eliminación" style="display:none;">
            <p>
                <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
                ¿Seguro que deseas eliminar este usuario? Esta acción no se puede deshacer ⚠️
            </p>
        </div>

    </div> <!-- fin spa-container -->

    <script src="js/jquery-3.7.1.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

    <style>
        .join-btn {
            position: relative;
            background: #ff7043;
            border: none;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;}
        .join-btn .dropdown {
            display: none; /* Oculto por defecto */
            position: absolute;
            top: 40px;
            right: 0;
            background: #ffffffff;
            border: 1px solid #ffffffff;
            border-radius: 8px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.15);
            padding: 8px 0;
            min-width: 140px;
            z-index: 1000; }
        .join-btn:hover .dropdown { display: block;     background: #ffffffff;}
        .join-btn .dropdown button {
            display: block;
            width: 100%;
            padding: 8px 12px;
            border: none;
            text-align: left;
            cursor: pointer;}
        .join-btn .dropdown button:hover {
            background: #e2b3b3ff;
        }

    </style>
</body>

</html>
