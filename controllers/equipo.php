<?php
    session_start();
    require_once '../models/equipo.php';
    

    if (isset($_POST['op'])) {
        $equipo = new Equipo();

        if ($_POST['op'] == 'listar') {
            $datos = $equipo->listar();
            foreach ($datos as $registro) {
                $datos_equipo = json_decode($registro['datos'], true);
                $estado = $datos_equipo['estado'] == 1 ? 'Activo' : $datos_equipo['estado'];
                $numIntegrantes = count($datos_equipo['integrantes']);
                echo "
                <tr>
                    <td class='p-3' data-label='#'>{$registro['id']}</td>
                    <td class='p-3' data-label='Nombre'>{$datos_equipo['nombre']}</td>
                    <td class='p-3' data-label='Integrantes'>$numIntegrantes</td>
                    <td class='p-3' data-label='Fecha de Registro'>{$datos_equipo['fechaRegistro']}</td>
                    <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                    <td data-label='Acciones'>
                    <div class='btn-group' role='group'>
                      <button type='button' id='editar-boton' data-id='{$registro['id']}' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                      <button type='button' id='registrar-integrante' data-id='{$registro['id']}' title='Click para registrar un nuevo integrante' class='registrar btn btn-outline-success btn-sm'><i class='fa-regular fa-plus'></i></button>
                      <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                    </div>
                  </td>
                </tr>
                ";
            }
        }

        if ($_POST['op'] == 'registrarEquipo') {
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'];
            $equipo->registrarEquipo($nombre, $estado);
        }

        if ($_POST['op'] == 'obtenerDatos') {
            $datos = $equipo->obtenerDatos($_POST['id']);

            // Intanciamos la clase Persona:
            require_once '../models/persona.php';
            $persona = new Persona();

            // Obtener los datos de los integrantes
            $integrantes = $datos['integrantes'];

            // El foreach para obtener los datos de cada integrante
            foreach ($integrantes as &$integrante) {

                // Instanceamos a la clase Usuario
                require_once '../models/usuario.php';
                $usuario = new Usuario();
                $datosUsuario = $usuario->obtenerDatos($integrante['idUsuario']);
                
                // Obtener el ID de la persona desde los datos del usuario
                $idPersona = $datosUsuario['idPersona'];

                // Acá pasamos el ID de la persona pero con el contenido de idPersona que está en la tabla usuario
                // obtenido en el campo datos de la tabla equipo
                $datos_persona =$persona->obtenerDatos($idPersona);

                // Acá agregamos los datos de la persona a cada integrante registrado
                $integrante['datosEmpleado'] = $datos_persona;

                // Agregar los campos "correo", "user" y "cargo" al campo datosEmpleado
                $integrante['datosEmpleado']['correo'] = $datosUsuario['correo'];
                $integrante['datosEmpleado']['user'] = $datosUsuario['user'];
                $integrante['datosEmpleado']['cargo'] = $datosUsuario['cargo'];


                // Acá agregamos los datos de los integrantes al resultado de la operación 
                $datos['integrantes'] = $integrantes;

                // Obtenemos el idTipoDocumento de datosEmpleado
                $idTipoDocumento = $integrante['datosEmpleado']['idTipoDocumento'];

                // Acá utilizamos la funcion obtenerTipoDocumento del models persona
                $nombreDocumento = $persona->obtenerTipoDocumento($idTipoDocumento);
                
                // Agregamos una nueva clave valor a datosPersona (nombreDocumento) y agregamos el valor que nos arroja la funcion obtenerDocumento
                $integrante['datosEmpleado']['nombreTipoDocumento'] = $nombreDocumento['nombre'];
            }
            // Devolvemos los datos en JSON de manera ordenada o legible 
            echo json_encode($datos, JSON_PRETTY_PRINT);
        }

        if ($_POST['op'] == 'registrarIntegrante') {
            require_once '../models/usuario.php';
            $usuario = new Usuario();
        
            $idEquipo = $_POST['id'];
            $idUsuario = $_POST['idUsuario'];
            $idIntegrante = $_POST['idIntegrante'];
        
            $datosUser = $usuario->obtenerDatos($idUsuario);
        
            if ($datosUser['equipo'] != '0') {
                $mensaje = "El usuario ya tiene un equipo asignado";
                echo $mensaje;
            } else {
                $respuesta = $equipo->registrarIntegrante($idUsuario, $idIntegrante, $idEquipo);
        
                if ($respuesta['error']) {
                    $mensaje = "Error al registrar la fecha: " . $respuesta['mensaje'];
                } else {
                    $datos = $equipo->asignarEquipo($idEquipo, $idUsuario);
                    $mensaje = "Fecha registrada correctamente";
                }
        
                echo $mensaje;
            }
        }

        if ($_POST['op'] == 'asignarFechaSalida') {
            $idEquipo = $_POST['id'];
            $respuesta = $equipo->asignarFechaSalida($idEquipo);
            if ($respuesta['error']) {
                $mensaje = "Error al registrar el integrante: " . $respuesta['mensaje'];
            } else {
                $mensaje = "Registro completado";
            }

            echo $mensaje;
        }

        if ($_POST['op'] == 'asignarHoraSalida') {
            $idEquipo = $_POST['id'];
            $respuesta = $equipo->asignarHoraSalida($idEquipo);
            if ($respuesta['error']) {
                $mensaje = "Error al registrar la hora: " . $respuesta['mensaje'];
            } else {
                $mensaje = "Hora registrada correctamente";
            }

            echo $mensaje;
        }

        if ($_POST['op'] == 'asignarEstado') {
            $idEquipo = $_POST['id'];
            $respuesta = $equipo->asignarEstado($idEquipo);
            if ($respuesta['error']) {
                $mensaje = "Error al cambiar el estado: " . $respuesta['mensaje'];
            } else {
                $mensaje = "Estado cambiado correctamente";
            }

            echo $mensaje;
        }

        if ($_POST['op'] == 'listarEmpleados') {
            //Llamamos a la clase Usuario del archivo usuario.php para poder traer la función obtenerDatos
            require_once '../models/usuario.php';
            require_once '../models/persona.php';
            $usuario = new Usuario();
            $persona = new Persona();
            $datos = $usuario->listar();

            foreach ($datos as $registro) {
                $datos_equipo = json_decode($registro['datos'], true);
                $estado = $datos_equipo['estado'] == 1 ? 'Activo' : $datos_equipo['estado'];
                $datos_persona = $persona->obtenerDatos($datos_equipo['idPersona']);
                echo "
                <tr>
                    <td class='p-3' data-label='#'>{$registro['id']}</td>
                    <td class='p-3' data-label='Apellido'>{$datos_persona['apellidos']}</td>
                    <td class='p-3' data-label='Nombre'>{$datos_persona['nombre']}</td>
                    <td class='p-3' data-label='Correo'>{$datos_equipo['correo']}</td>
                    <td class='p-3' data-label='Usuario'>{$datos_equipo['user']}</td>
                    <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                    <td data-label='Acciones'>
                    <div class='btn-group' role='group'>
                    <button type='button' id='editar-boton' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                    <button type='button' id='registrar-integrante' data-idusuario='{$registro['id']}' title='Click para registrar en el equipo' class='registrar-empleado btn btn-outline-success btn-sm'><i class='fa-regular fa-plus'></i></button>
                    <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                    </div>
                </td>
                </tr>
                ";
            }
        }
        
        if ($_POST['op'] == 'obtenerIntegrantesPorEstado') {
            $datos = $equipo->obtenerIntegrantesPorEstado($_POST['id']);
            
            // Obtener los datos de los integrantes
            $datos['id'] = $_POST['id'];
            $integrantes = $datos['integrantes'];
            require_once '../models/usuario.php';
            require_once '../models/persona.php';
            $persona = new Persona();
            $usuario = new Usuario();
            
            // El foreach para obtener los datos de cada integrante
            foreach ($integrantes as &$integrante) {
                // Obtenemos el idUsuario de integrantes
                $idUsuario = $integrante['idUsuario'];
                // Lo usamos para usar la funcion obtenerDatos de usuario.php
                $datosUsuario = $usuario->obtenerDatos($idUsuario);
                // Hacemos lo mismo con la clase persona pero esta ves sacamos el id de la persona con
                // el idPersona que está en los datos de los usuarios
                $idPersona = $datosUsuario['idPersona'];
                $datosPersona = $persona->obtenerDatos($idPersona);
                // Creamos un array datosEmpleado dentro de integrantes y ahí insertamos los datos de la persona
                $integrante['datosEmpleado'] = $datosPersona;
            
                // Agregar los campos "correo", "user" y "cargo" al campo datosEmpleado
                $datosPersona['correo'] = $datosUsuario['correo'];
                $datosPersona['user'] = $datosUsuario['user'];
                $datosPersona['cargo'] = $datosUsuario['cargo'];
            
                // Acá agregamos los datos de los integrantes al resultado de la operación 
                $datos['integrantes'] = $integrantes;
                // Obtenemos el nombre del tipo de documento
                $idTipoDocumento = $datosPersona['idTipoDocumento'];
                $nombreDocumento = $persona->obtenerTipoDocumento($idTipoDocumento);
                $datosPersona['nombreTipoDocumento'] = $nombreDocumento['nombre'];
            
                // Reemplazar los datosEmpleado con los datos de la persona
                $integrante['datosEmpleado'] = $datosPersona;
            }
            // Devolver los datos en formato JSON
            echo json_encode($datos, JSON_PRETTY_PRINT);
        }

        if ($_POST['op'] == 'cambiarEstadoIntegrante') {
            $idUsuario = $_POST['idUsuario'];
            $idEquipo = $_POST['id'];
            
            // Crear una instancia del modelo
            $equipo = new Equipo();
        
            // Cambiar el estado del integrante en todos los equipos
            $equipo->cambiarEstadoIntegrante($idUsuario,$idEquipo);
            $equipo->cambiarFechaSalida($idUsuario,$idEquipo);
            $equipo->cambiarHoraSalida($idUsuario,$idEquipo);
            $equipo->quitarEquipo($idUsuario);
        
            // Enviar respuesta exitosa
            echo json_encode(['success' => true]);
        }

        
        

    }

?>