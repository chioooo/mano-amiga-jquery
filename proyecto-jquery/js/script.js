$(document).ready(function () {

    $.getJSON("ajax/check_session.php", function (res) {
        if (res.logged_in) {
            $(".auth-page").hide();
            $("#main-page").show();
            $("#inicio").addClass("active");
            $(".sidebar a[data-section='inicio']").addClass("active");
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
                    $("#inicio").addClass("active");
                    $(".sidebar a[data-section='inicio']").addClass("active");
                } else {
                    $(".sidebar a").show();
                }
            } else {
                alert(res.message);
            }

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

    //Dropdown usuario
    $(".user-btn i").on("click", function () {
        $(".user-btn .dropdown").toggle();
    });

    $(document).on("click", function (e) {
        if (!$(e.target).closest(".user-btn").length) {
            $(".user-btn .dropdown").hide();
        }
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

    // Guardar siniestro
    $("#siniestro-form").submit(function (e) {
        e.preventDefault();

        let id = $("#siniestro_id").val();
        let location = $("#location").val();
        let level = $("#level").val();
        let date_time = $("#date_time").val();
        let resources = $("#resources").val();
        let active = $("#active").is(":checked") ? 1 : 0;

        let url = id ? "ajax/siniestros/siniestros_update.php" : "ajax/siniestros_add.php";

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
    $(document).on("click", ".btn-edit", function () {
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

    // Eliminar
    let siniestroIdToDelete = null;
    $("#confirmDeleteDialog").dialog({
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
    $(document).on("click", ".btn-delete", function () {
        siniestroIdToDelete = $(this).data("id");
        $("#confirmDeleteDialog").dialog("open");
    });

    // Cargar siniestros en tabla
    function cargarSiniestros() {
        $.get("ajax/siniestros_list.php", function (res) {
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
                        <button class="btn-edit" data-id="${s.id}"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn-delete" data-id="${s.id}"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            `);
            });
        }, "json");
    }

    $(".btn-delete").tooltip({
        content: "Eliminar"
    });

    $(".menu-item[data-section='siniestros']").click(function () {
        cargarSiniestros();
    });

    //Cargar siniestros en posts
    function cargarPosts() {
        $.get("ajax/siniestros_list.php", function (res) {
            let postsContainer = $("#inicio .posts");
            postsContainer.empty(); // limpiamos los posts

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
                        <button class="join-btn">Quiero unirme</button>
                        <span class="counter">0 voluntarios</span>
                    </div>
                </div>
            `);
            });
        }, "json");
    }

    function cargarUsuarios() {
        $.get("ajax/usuarios/usuarios_list.php", function (res) {
            let tbody = $("#usuarios-table tbody");
            tbody.empty();
            res.forEach(s => {
                tbody.append(`
                <tr>
                    <td>${s.id}</td>
                    <td>${s.full_name}</td>
                    <td>${s.username}</td>
                    <td>${s.is_admin == 1 ? "Sí" : "No"}</td>
                    <td>${s.siniestro_id || ''}</td>
                    <td>
                        <button class="btn-edit-user">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button class="btn-delete-user">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
            });
        }, "json");
    }

    $(".menu-item[data-section='usuarios']").click(function () {
        cargarUsuarios();
    });
});
