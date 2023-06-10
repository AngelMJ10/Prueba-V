<?php

  session_start();

  $_SESSION['login'] = false;
  $_SESSION['id'] = "";
  $_SESSION['apellido'] = "";
  $_SESSION['nombre'] = "";

  require_once '../models/usuario.php';

  if (isset($_POST['op'])) {
    $usuario = new Usuario();

    if ($_POST['op'] == 'listar') {
        $datos = $usuario->listar();
        foreach ($datos as $registro) {
            $datos_equipo = json_decode($registro['datos'], true);
            $estado = $datos_equipo['estado'] == 1 ? 'Activo' : $datos_equipo['estado'];
            echo "
            <tr>
                <td class='p-3' data-label='#'>{$registro['id']}</td>
                <td class='p-3' data-label='Apellido'>{$datos_equipo['apellido']}</td>
                <td class='p-3' data-label='Nombre'>{$datos_equipo['nombre']}</td>
                <td class='p-3' data-label='Correo'>{$datos_equipo['correo']}</td>
                <td class='p-3' data-label='Usuario'>{$datos_equipo['user']}</td>
                <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                <td data-label='Acciones'>
                <div class='btn-group' role='group'>
                  <button type='button' id='editar-boton' data-id='{$registro['id']}' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                  <button type='button' id='registrar-integrante' data-id='{$registro['id']}' title='Click para registrar un nuevo integrante' class='btn btn-outline-success btn-sm'><i class='fa-regular fa-plus'></i></button>
                  <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                </div>
              </td>
            </tr>
            ";
        }
    }

    if ($_POST['op'] == 'login'){
        $resultado =[
            "acceso"        => false,
            "mensaje"       => "",
            "apellido"     => "",
            "nombre"       => "",
            "tipoUsuario"   => ""
        ];

        //1. Verificar si existe el usuario (data = 0, 1)
        $data =  $usuario->login($_POST['correo']);

        if ($data) {
            //2. El el email existe ,toca validar la clave
            // Obtener el valor del campo datos
            $datosJson = $data[0]['datos'];

            // Decodificar el JSON en un array asociativo
            $datosArray = json_decode($datosJson, true);

            // Obtener el valor de la clave dentro del array decodificado
            $claveEncriptada = $datosArray['clave'];


            //3. Comprobar la clave de entrada(login) con la encriptada
            if (password_verify($_POST['contraseña'], $claveEncriptada)) {
                //Enviamos toda la info del usuario
                $resultado["acceso"] = true;
                $resultado["mensaje"] = "Bienvenido al Sistema";
                $resultado["apellido"] = $datosArray["apellido"];
                $resultado["nombre"] = $datosArray["nombre"];
                $resultado["tipoUsuario"] = $datosArray["cargo"];
    
                $_SESSION['login'] = true;
                $_SESSION['id'] = $data[0]['id'];
                $_SESSION['apellido'] = $datosArray['apellido'];
                $_SESSION['nombre'] = $datosArray['nombre'];
            } else {
                //La contraseña es incorrecta
                $resultado['acceso'] = false;
                $resultado['mensaje'] = "La contraseña es incorrecta";
            }
        } else {
            //Email incorrecto
            $resultado['acceso'] = false;
            $resultado['mensaje'] = "El email no existe";
        }
        //Enviando datos al view...
        echo json_encode($resultado);
    }

    if ($_POST['op'] == 'registrarUsuario') {
        $idPersona = $_POST['idPersona'];
        $correo = $_POST['correo'];
        $clave = password_hash($_POST['clave'],PASSWORD_BCRYPT);
        $user = $_POST['user'];
        $cargo = $_POST['cargo'];
        $direccion = $_POST['direccion'];
        $usuario->registrarUsuario($idPersona, $correo, $clave, $user, $cargo, $direccion);
    }

    if ($_POST['op'] == 'cerrar-sesion'){
        session_destroy();
        session_unset();
        header("location:../index.php");
    }

    if ($_POST['op'] == 'obtenerDatos') {
        $datos = $usuario->obtenerDatos($_POST['id']);

        // Instanciamos la clase persona: 
        require_once '../models/persona.php';
        $persona = new Persona();

        // Obtenemos los datos de la persona
        $idPersona = $datos['idPersona'];

        $datos_persona = $persona->obtenerDatos($idPersona);
        $datos['datosPersona']  = $datos_persona;

            
        // Obtenemos el idTipoDocumento de datosPersona
        $idTipoDocumento = $datos_persona['idTipoDocumento'];

        // Acá utilizamos la funcion obtenerTipoDocumento del models persona
        $nombreDocumento = $persona->obtenerTipoDocumento($idTipoDocumento);
        
        // Agregamos una nueva clave valor a datosPersona (nombreDocumento) y agregamos el valor que nos arroja la funcion obtenerDocumento
        $datos['datosPersona']['nombreTipoDocumento'] = $nombreDocumento['nombre'];
        // Devolvemos los datos en JSON de manera ordenada o legible 
        echo json_encode($datos, JSON_PRETTY_PRINT);
    }

}

?>