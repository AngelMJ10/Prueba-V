<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Lightbox -->
    <link rel="stylesheet" href="vendor/lightbox/css/lightbox.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Registrarse</title>
</head>
<body>

    <div class="container mt-2">
        <form action="" id="formulario-users" autocomplete="off">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <h3>Registrarse</h3>

                    <div class="mb-3">
                    <label for="apellidos" class="form-label">Escriba sus apellidos</label>
                    <input type="text" id="apellidos" class="form-control" placeholder="Apellidos">
                    </div>

                    <div class="mb-3">
                    <label for="nombres" class="form-label">Escriba sus nombres</label>
                    <input type="text" id="nombres" class="form-control" placeholder="Nombres">
                    </div>

                    <div class="mb-3">
                    <label for="email" class="form-label">Escriba su email</label>
                    <input type="text" id="email" class="form-control" placeholder="Example@email.com">
                    </div>

                    <div class="mb-3">
                    <label for="claveacceso1" class="form-label">Escriba su contraseña</label>
                    <input type="password" id="claveacceso1" class="form-control" placeholder="Contraseña">
                    </div>

                    <div class="mb-3">
                    <label for="claveacceso2" class="form-label">Vuelva a escribir su contraseña</label>
                    <input type="password" id="claveacceso2" class="form-control" placeholder="Contraseña">
                    </div>

                    <div class="form-group text-right">
                        <button class="btn btn-outline-primary" id="registrar" type="button">Registrarse</button>
                        <button class="btn btn-outline-secondary" id="cancelar" type="reset">Cancelar</button>
                        <a class="btn btn-outline-info" id="login" href="index.php">Iniciar Sesión</a>
                    </div>
                    <!-- End Formulary -->
                </div>
                <div class="col-md-3"></div>
            </div>
        </form>
    </div>

    <!-- SWEET ALERT -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>  

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {

            let apellidos = "";
            let nombres = "";
            let email = "";
            let claveacceso1 = "";
            let claveacceso2 = "";

            function alertar (textoMensaje = ""){
                Swal.fire({
                    title               : "Usuario",
                    text                : textoMensaje,
                    icon                : "info",
                    footer              : "SENATI - Ingeniería de Software",
                    timer               : 2000,
                    confirmButtonText   : "Aceptar"
                });
            }

            function sendAjax(){
                let datos = {
                    "operacion"             : "registrarUsuario",
                    "apellidos"             : apellidos,
                    "nombres"               : nombres,
                    "email"                 : email,
                    "claveacceso"           : claveacceso1
                };
                $.ajax({
                    url:  'controllers/usuario.php',
                    type: 'GET',
                    data : datos,
                    success: function (result){
                        if ($.trim(result) == "") {
                            alertar("Nuevo usuario registrado");
                        }
                    }
                });
            }

            function registrarUsuario(){
                apellidos               = $("#apellidos").val();
                nombres                 = $("#nombres").val();
                email                   = $("#email").val();
                claveacceso1             = $("#claveacceso1").val();
                claveacceso2             = $("#claveacceso2").val();
                
                if (apellidos == "" || nombres == "" || email == "" || claveacceso1 == "" || claveacceso2 == "") {
                    alertar("Complete el formulario por favor");
                }else{
                    if (claveacceso1 != claveacceso2) {
                        alertar("Las contraseñas no coinciden");
                    }else{
                        Swal.fire({
                            title                       : "Usuarios",
                            text                        : "¿Seguro de los datos?",
                            icon                        : "question",
                            footer                      : "SENATI - Ingeniería de Software",
                            confirmButtonText           : "Aceptar",
                            showCancelButton            : true,
                            cancelButtonText            : "Cancelar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                sendAjax();
                                $("#formulario-users")[0].reset();
                            }
                        });
                    }
                }
            }

            $("#registrar").click(registrarUsuario);

        });
    </script>

</body>
</html>