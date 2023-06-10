<?php

 session_start();

//¡CUIDADO!
//Si el usuario YA inició sesión, NO debe visualizar este view
if (isset($_SESSION['login']) && $_SESSION['login'] == true){
    header("location:views/persona.php");
  }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>VAMAS</title>
</head>
<body>
    <div class="container">
        <form action="" autocomplete="off">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <!-- Formulario de inicio de sesión -->
                <h3 class="mt-3">Inicio de sesión</h3>
                <div class="form-group mb-4">
                    <label for="email">Escriba su correo</label>
                    <input type="email" class="form-control" id="email" placeholder="micorreo@gmail.com">
                </div>

                <div class="form-group mb-4">
                    <label for="clave">Contraseña</label>
                    <input type="password" class="form-control" id="claveacceso">
                </div>

                <div class="form-group text-right mb-3">
                    <button class="btn btn-outline-info me-3" id="acceder" type="button">Acceder</button>
                    <a class="btn  btn-outline-dark" id="registrar" href="registrar-user.php">Registrarse</a>
                </div>
                <a href="restaurar-user.php">Olvidé mi contraseña</a>
                <!-- Fin del formulario -->
            </div>
            <div class="col-md-3"></div>
        </div> <!-- Fin row -->
        </form>
    </div>

    <!-- LINKS -->
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function (){
        function login() {
            let email = $("#email").val();
            let clave = $("#claveacceso").val();

            $.ajax({
                url: 'controllers/usuario.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'op': 'login',
                    'correo': email,
                    'contraseña': clave
                },
                success: function(result) {
                    if (result.acceso) {
                        alert(`Bienvenid@ al sistema ${result.apellido} ${result.nombre}`);
                        window.location.href = 'views/persona.php';
                    } else {
                        alert(result.mensaje);
                    }
                }
            });
        }
        $("#acceder").click(login);
    });
</script>

</body>
</html>