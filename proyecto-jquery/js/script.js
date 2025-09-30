$(document).ready(function () {

    $.getJSON("ajax/check_session.php", function (res) {
        if (res.logged_in) {
            $(".auth-page").hide();
            $("#main-page").show();
            $("#inicio").addClass("active");
            $(".sidebar a[data-section='inicio']").addClass("active");
            if (res.is_admin === 0) {
                $(".sidebar a").hide();
                $(".sidebar a[data-section='inicio']").show();
                $(".sidebar a[data-section='profile-section']").show();
                $("#inicio").addClass("active");
                $(".sidebar a[data-section='inicio']").addClass("active");
            } else {
                $(".sidebar a").show();
            }
            cargarPosts();
        } else {
            $("#login-page").show();
            $("#main-page").hide();
        }
    });

    $("#go-register").click(function () {
        $("#login-page").hide();
        $("#register-page").show();
    });

    $("#go-login").click(function () {
        $("#register-page").hide();
        $("#login-page").show();
    });

    // Registro
    $("#register-form").submit(function (e) {
        e.preventDefault();
        let fullname = $("#register-fullname").val();
        let username = $("#register-username").val();
        let password = $("#register-password").val();

        $.post("ajax/register.php", {fullname, username, password}, function (res) {
            if (res.status === "success") {
                $("#register-page").hide();
                $("#login-page").show();
            } else {
                alert(res.message);
            }
        }, "json");
    });

    // Login
    $("#login-form").submit(function (e) {
        e.preventDefault();
        let username = $("#login-username").val();
        let password = $("#login-password").val();

        $.post("ajax/login.php", {username, password}, function (res) {
            if (res.status === "success") {
                $(".auth-page").hide();
                $("#main-page").fadeIn();

                if (res.is_admin === 0) {
                    $(".sidebar a").hide();
                    $(".sidebar a[data-section='inicio']").show();
                    $(".sidebar a[data-section='profile-section']").show();
                    $("#inicio").addClass("active");
                    $(".sidebar a[data-section='inicio']").addClass("active");
                } else {
                    $(".sidebar a").show();
                }
            } else {
                alert(res.message);
            }
            $("body").removeClass("login-register").addClass("main-page");

            cargarPosts();
        }, "json");
    });

    $("#inicio").addClass("active");
    $(".sidebar a[data-section='inicio']").addClass("active");

    $(".menu-item").click(function (e) {
        e.preventDefault();
        let section = $(this).data("section");

        // Marcar menú activo
        $(".menu-item").removeClass("active");
        $(this).addClass("active");

        $(".section").removeClass("active");
        $("#" + section).addClass("active");
    });

    $(".menu-item[data-section='inicio']").click(function () {
        cargarPosts();
    });

    //Cerrar sesión
    $("#btn-logout").on("click", function () {
        $.ajax({
            url: "ajax/logout.php",
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    // Regresar al login
                    $("#main-page").hide();
                    $("body").removeClass("main-page").addClass("login-register");
                    $("#login-page").show();
                }
            },
            error: function () {
                alert("Error al cerrar sesión");
            }
        });
    });

    // Abrir modal
    $("#btn-new-siniestro").click(function () {
        $("#modal-siniestro").addClass("active");
    });

    // Cerrar modal
    $("#cerrar-modal").click(function () {
        $("#modal-siniestro").removeClass("active");
    });

    // Cerrar
    $("#modal-siniestro").click(function (e) {
        if (e.target === this) {
            $(this).removeClass("active");
        }
    });

    // Cerrar modal usuarios
    $("#cerrar-modal-usuarios").click(function () {
        $("#modal-usuarios").removeClass("active");
    });

    // Cerrar
    $("#modal-usuarios").click(function (e) {
        if (e.target === this) {
            $(this).removeClass("active");
        }
    });

    //como voluntario
    $(document).on("click", ".btn-volu", function () {
        let siniestroId = $(this).data("siniestro-id");

        $.post("ajax/usuarios/usuarios_update_voluntario.php", {
            siniestro_id: siniestroId
        }, function (res) {
            if (res.status === "success") {
                alert("Te has unido como voluntario al siniestro.");
                cargarPosts();
            } else {
                alert(res.message);
            }
        }, "json");
    });

    //como voluntario y donador
    $(document).on("click", ".btn-volu-don", function () {
        let siniestroId = $(this).data("siniestro-id");
        $("#siniestro_id").val(siniestroId);
        $("#modal-recursos").addClass("active");

        $("#recursos-form").data("volu-don", true);
    });

    // Abrir modal recursos
    $(document).on("click", ".btn-don", function () {
        let siniestroId = $(this).data("siniestro-id");
        $("#siniestro_id").val(siniestroId);
        $("#modal-recursos").addClass("active");
        $("#recursos-form")[0].reset();
        $("#recursos_id").val("");
    });

    // cerrar modal recursos
    $("#cerrar-modal-recursos").click(function () {
        $("#modal-recursos").removeClass("active");
    });

    // Cerrar
    $("#modal-recursos").click(function (e) {
        if (e.target === this) {
            $(this).removeClass("active");
        }
    });

    // Guardar siniestro
    $("#siniestro-form").submit(function (e) {
        e.preventDefault();

        let id = $("#siniestro_id").val();
        let location = $("#location").val();
        let level = $("#level").val();
        let date_time = $("#date_time").val();
        let resources = $("#resources").val();
        let active = $("#active").is(":checked") ? 1 : 0;

        let url = id ? "ajax/siniestros/siniestros_update.php" : "ajax/siniestros/siniestros_add.php";

        $.post(url, {
            id,
            location,
            level,
            date_time,
            resources,
            active
        }, function (res) {
            if (res.status === "success") {
                $("#modal-siniestro").removeClass('active');
                $("#siniestro-form")[0].reset();
                $("#siniestro_id").val("");
                cargarSiniestros();
            } else {
                alert(res.message);
            }
        }, "json");
    });

    // Editar
    $(document).on("click", "#btn-edit", function () {
        let id = $(this).data("id");

        $.get("ajax/siniestros/siniestros_get.php", {id}, function (res) {
            if (res) {
                $("#siniestro_id").val(res.id);
                $("#location").val(res.location);
                $("#level").val(res.level);
                $("#date_time").val(res.date_time);
                $("#resources").val(res.resources);
                $("#active").prop("checked", res.active == 1);

                $("#modal-siniestro").addClass("active");
            }
        }, "json");
    });

    // Eliminar siniestros
    let siniestroIdToDelete = null;
    $("#confirmSiniestroDeleteDialog").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 400,
        buttons: {
            "Eliminar": function () {
                if (siniestroIdToDelete) {
                    $.ajax({
                        url: "ajax/siniestros/siniestros_delete.php",
                        type: "POST",
                        data: {id: siniestroIdToDelete},
                        dataType: "json",
                        success: function (response) {
                            if (response.status === "success") {
                                cargarSiniestros();
                            } else {
                                alert("Error: " + response.message);
                            }
                            siniestroIdToDelete = null;
                        },
                        error: function () {
                            alert("Error al conectar con el servidor ❌");
                        }
                    });
                }
                $(this).dialog("close");
            },
            "Cancelar": function () {
                $(this).dialog("close");
            }
        }
    });

// boton eliminar
    $(document).on("click", "#btn-delete", function () {
        siniestroIdToDelete = $(this).data("id");
        $("#confirmSiniestroDeleteDialog").dialog("open");
    });

    // Cargar siniestros en tabla
    function cargarSiniestros() {
        $.get("ajax/siniestros/siniestros_list.php", function (res) {
            let tbody = $("#siniestros-table tbody");
            tbody.empty();
            res.forEach(s => {
                tbody.append(`
                <tr>
                    <td>${s.id}</td>
                    <td>${s.location}</td>
                    <td>${s.level}</td>
                    <td>${s.date_time}</td>
                    <td>${s.resources}</td>
                    <td>${s.active == 1 ? "Sí" : "No"}</td>
                    <td>
                        <button id="btn-edit" class="edit" data-id="${s.id}"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button id="btn-delete" class="delete" data-id="${s.id}"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            `);
            });
        }, "json");
    }

    $(".menu-item[data-section='siniestros']").click(function () {
        cargarSiniestros();
    });

    //Cargar siniestros en posts
    function cargarPosts() {
        $.get("ajax/siniestros/siniestros_list.php", function (res) {
            let postsContainer = $("#inicio .posts");
            postsContainer.empty();

            res.forEach(s => {
                postsContainer.append(`
                <div class="post">
                    <div class="post-header">
                        <h3>🔥 Siniestro nivel ${s.level}</h3>
                        <span class="level">Nivel: ${s.level}</span>
                    </div>

                    <div class="post-body">
                        <div class="izquierda">
                            <p><strong>Dirección:</strong> ${s.location}</p>
                            <p><strong>Fecha y hora:</strong> ${s.date_time}</p>

                            <div class="resources">
                                <p><strong>Recursos y herramientas necesarias:</strong></p>
                                <ul>
                                    ${s.resources.split(",").map(r => `<li>${r.trim()}</li>`).join("")}
                                </ul>
                            </div>
                        </div>

                        <div class="derecha">
                            <img src="img/incendio.jpg" alt="Siniestro">
                        </div>
                    </div>

                    <div class="post-footer">
                        
                        <div class="join-btn">
                            Quiero unirme
                            <div class="dropdown">
                                <button class="btn-volu" data-siniestro-id="${s.id}">Como voluntario</button>
                                <button class="btn-don" data-siniestro-id="${s.id}">Como donador</button>
                                <button class="btn-volu-don" data-siniestro-id="${s.id}">Como voluntario y donador</button>
                            </div>
                        </div>
                        <span class="counter">${s.total_voluntarios} voluntarios</span>

                    </div>
                </div>
            `);
            });
        }, "json");
        $("body").removeClass("login-register").addClass("main-page");
    }

    //cargar usuarios
    function cargarUsuarios() {
        $.get("ajax/usuarios/usuarios_list.php", function (res) {
            let tbody = $("#usuarios-table tbody");
            tbody.empty();
            res.forEach(u => {
                tbody.append(`
                <tr>
                    <td>${u.id}</td>
                    <td>${u.full_name}</td>
                    <td>${u.username}</td>
                    <td>${u.is_admin === 1 ? "Sí" : "No"}</td>
                    <td>${u.siniestro_id || ''}</td>
                    <td>
                        <button class="btn-edit-user edit" data-id="${u.id}"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn-delete-user delete" data-id="${u.id}"><i class="fa-solid fa-trash"></i></button>

                    </td>
                </tr>
            `);
            });
        }, "json");
    }

    $(".menu-item[data-section='usuarios']").click(function () {
        cargarUsuarios();
    });

    // Abrir editar usuario
    $(document).on("click", ".btn-edit-user", function () {
        let id = $(this).data("id");

        $.get("ajax/usuarios/usuarios_get.php", {id}, function (res) {
            if (res) {
                $("#usuario_id").val(res.id);
                $("#fullname").val(res.full_name);
                $("#username").val(res.username);
                $("#password").val('');
                $("#is_admin").prop("checked", res.is_admin == 1);

                $("#modal-usuarios").addClass("active");
            }
        }, "json");
    });

    // Editar usuario
    $("#usuario-form").submit(function (e) {
        e.preventDefault();

        let id = $("#usuario_id").val();
        let fullname = $("#fullname").val();
        let username = $("#username").val();
        let password = $("#password").val();
        let is_admin = $("#is_admin").is(":checked") ? 1 : 0;

        let data = { id, fullname, username, is_admin };

        if (password.trim() !== '') {
            data.password = password;
        }

        console.log("Datos para actualizar usuario:", { id, fullname, username, is_admin, password });

        $.post("ajax/usuarios/usuarios_update.php", data, function (res) {
            if (res.status === "success") {
                $("#modal-usuarios").removeClass("active");
                $("#usuario-form")[0].reset();
                $("#usuario_id").val("");
                cargarUsuarios();
            } else {
                alert(res.message);
            }
        }, "json");
    });

    // Eliminar usuarios
    let usuariosIdToDelete = null;
    $("#confirmUsuarioDeleteDialog").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 400,
        buttons: {
            "Eliminar": function () {
                if (usuariosIdToDelete) {
                    $.ajax({
                        url: "ajax/usuarios/usuarios_delete.php",
                        type: "POST",
                        data: {id: usuariosIdToDelete},
                        dataType: "json",
                        success: function (response) {
                            if (response.status === "success") {
                                cargarUsuarios();
                            } else {
                                alert("Error: " + response.message);
                            }
                            usuariosIdToDelete = null;
                        },
                        error: function () {
                            alert("Error al conectar con el servidor ❌");
                        }
                    });
                }
                $(this).dialog("close");
            },
            "Cancelar": function () {
                $(this).dialog("close");
            }
        }
    });

    // boton eliminar
    $(document).on("click", ".btn-delete-user", function () {
        usuariosIdToDelete = $(this).data("id");
        $("#confirmUsuarioDeleteDialog").dialog("open");
    });

    //ver perfil
    function verperfil(){
        $.get("ajax/usuarios/usuarios_gets.php", function (res) {
            let tbody = $(".profile");
            tbody.empty();
            if (res) {
                let siniestroHtml = "";
                if (res.siniestro_id) {
                    siniestroHtml = `
                    <div class="siniestro-info">
                        <h3>🔥 Siniestro unido</h3>
                        <p><strong>Nivel:</strong> ${res.siniestro_level}</p>
                        <p><strong>Dirección:</strong> ${res.siniestro_location}</p>
                        <p><strong>Fecha y hora:</strong> ${res.siniestro_date}</p>
                    </div>
                `;
                } else {
                    siniestroHtml = `<div class="siniestro-info"><p>No estás unido a ningún siniestro.</p></div>`;
                }

                tbody.append(`
                <div class="perfil-container">
                    <div id="avatar">
                        <img src="img/perfil.jpg" alt="foto de perfil">
                        <div class="user-info">
                            <h2>Nombre: ${res.full_name}</h2>
                            <h2>Usuario: ${res.username}</h2>
                            <h2>Tipo de usuario: ${res.is_admin == 1 ? "Administrador" : "Voluntario"}</h2>
                            <p>Activ@ desde ${res.fecha_registro}</p>
                        </div>
                    </div>
                    ${siniestroHtml}
                </div>
            `);
            }
        }, "json");
    }

    $(".menu-item[data-section='profile-section']").click(function () {
        verperfil();
    });

    //guardar recurso
    $("#recursos-form").submit(function (e) {
        e.preventDefault();
        let id = $("#recursos_id").val();
        let name = $("#name").val();
        let description = $("#description").val();
        let category = $("#category").val();
        let quantity = $("#cantidad").val();
        let siniestro_id = $("#siniestro_id").val();

        let url = id ? "ajax/siniestros/siniestros_update.php" : "ajax/recursos/recursos_add.php";

        $.post(url, {
            id,
            name,
            description,
            category,
            quantity,
            siniestro_id
        }, function (res) {
            if (res.status === "success") {

                if ($("#recursos-form").data("volu-don")) {
                    $.post("ajax/usuarios/usuarios_update_voluntario.php", {
                        siniestro_id: siniestro_id
                    });
                }

                $("#modal-recursos").removeClass('active');
                $("#recursos-form")[0].reset();
                $("#recursos_id").val("");
                $("#recursos-form").removeData("volu-don");
                cargarPosts();
            } else {
                alert(res.message);
            }
        }, "json");
    });

    //cargar recursos
    function cargarRecursos() {
        $.get("ajax/recursos/recursos_list.php", function (res) {
            let tbody = $("#recursos-table tbody");
            tbody.empty();
            res.forEach(u => {
                tbody.append(`
                <tr>
                    <td>${u.id}</td>
                    <td>${u.name}</td>
                    <td>${u.description}</td>
                    <td>${u.category}</td>
                    <td>${u.quantity}</td>
                    <td>${u.usuario_id}</td>
                    <td>${u.siniestro_id}</td>
                </tr>
            `);
            });
        }, "json");
    }

    $(".menu-item[data-section='recursos']").click(function () {
        cargarRecursos();
    });
});
