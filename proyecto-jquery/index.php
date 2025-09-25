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
                    <button id="btn-logout" class="join-btn"><i class="fa-solid fa-right-from-bracket"></i></button>
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

            <!-- Perfil -->
            <div id="profile-section" class="section">
                <div class="perfil">
                    <div class="profile">
                        <div id="avatar">
                            <img src="img/perfil.jpg" alt="foto de perfil">
                            <div class="user-info">
                                <h2> Nombre: Patricia Marlene Bravo Reyes</h2>
                                <h2>Usuario: mar n</h2>
                                <h2>Tipo de usuario: voluntario</h2>
                                <p>Activa desde septiembre del 2024</p>
                            </div>
                        </div>
                    </div>
                    <!-- Info -->
                    <div class="info">
                        <h3>Puntos: 150xp</h3>
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
                    <input type="password" id="password" placeholder="Contraseña" required>
                    <label>Administrador: </label>
                    <input type="checkbox" id="is_admin" checked>
                    <button type="submit">Guardar</button>
                    <button type="button" id="cerrar-modal-usuarios">Cancelar</button>
                </form>
            </div>
        </div>

        <div id="confirmDeleteDialog" title="Confirmar eliminación" style="display:none;">
            <p>
                <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
                ¿Seguro que deseas eliminar este siniestro? Esta acción no se puede deshacer ⚠️
            </p>
        </div>

    </div> <!-- fin spa-container -->

    <script src="js/jquery-3.7.1.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>
