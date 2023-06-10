<?php
    session_start();
    require_once '../models/persona.php';

    if (isset($_POST['op'])) {
        $persona = new Persona();

        if ($_POST['op'] == 'listarPersonas') {
            $datos = $persona->listarPersonas();
            foreach ($datos as $registro) {
                $datos_persona = json_decode($registro['datos'], true);
                $estado = $datos_persona['estado'] == 1 ? 'Activo' : $datos_persona['estado'];
                echo "
                <tr>
                    <td class='p-3' data-label='#'>{$registro['id']}</td>
                    <td class='p-3' data-label='Apellidos'>{$datos_persona['apellidos']}</td>
                    <td class='p-3' data-label='Nombre'>{$datos_persona['nombre']}</td>
                    <td class='p-3' data-label='Documento'>{$datos_persona['documento']}</td>
                    <td class='p-3' data-label='Fecha de Nacimiento'>{$datos_persona['fechaNacimiento']}</td>
                    <td class='p-3' data-label='Teléfono'>{$datos_persona['telefono']}</td>
                    <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                    <td data-label='Acciones'>
                    <div class='btn-group' role='group'>
                      <button type='button' id='editar-boton' data-id='{$registro['id']}' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                      <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                    </div>
                  </td>
                </tr>
                ";
            }
        }

        if ($_POST['op'] == 'listar') {
          $datos = $persona->listar();
          echo json_encode($datos);
        }

        if ($_POST['op'] == 'registrarPersonas') {
            $apellidos = $_POST['apellidos'];
            $nombre = $_POST['nombre'];
            $idTipoDocumento = $_POST['idTipoDocumento'];
            $documento = $_POST['documento'];
            $fechaNacimiento = $_POST['fechaNacimiento'];
            $telefono = $_POST['telefono'];
            $estado = $_POST['estado'];
            $persona->registrarPersonas($apellidos, $nombre, $idTipoDocumento, $documento, $fechaNacimiento, $telefono, $estado);
        }

        if ($_POST['op'] == 'editarPersona') {
            $apellidos = $_POST['apellidos'];
            $nombre = $_POST['nombre'];
            $idTipoDocumento = $_POST['idTipoDocumento'];
            $documento = $_POST['documento'];
            $fechaNacimiento = $_POST['fechaNacimiento'];
            $telefono = $_POST['telefono'];
            $estado = $_POST['estado'];
            $idpersona = $_POST['id'];
            $persona->editarPersona($apellidos, $nombre, $idTipoDocumento, $documento, $fechaNacimiento, $telefono, $estado,$idpersona);
        }

        if ($_POST['op'] == 'buscarApellido') {
            $datos = $persona->buscarApellido($_POST['apellidos']);
            foreach ($datos as $registro) {
                $datos_persona = json_decode($registro['datos'], true);
                $estado = $datos_persona['estado'] == 1 ? 'Activo' : $datos_persona['estado'];
                echo "
                <tr>
                    <td class='p-3' data-label='#'>{$registro['id']}</td>
                    <td class='p-3' data-label='Apellidos'>{$datos_persona['apellidos']}</td>
                    <td class='p-3' data-label='Nombre'>{$datos_persona['nombre']}</td>
                    <td class='p-3' data-label='Documento'>{$datos_persona['documento']}</td>
                    <td class='p-3' data-label='Fecha de Nacimiento'>{$datos_persona['fechaNacimiento']}</td>
                    <td class='p-3' data-label='Teléfono'>{$datos_persona['telefono']}</td>
                    <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                    <td data-label='Acciones'>
                    <div class='btn-group' role='group'>
                      <button type='button' id='editar-boton' data-id='{$registro['id']}' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                      <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                    </div>
                  </td>
                </tr>
                ";
            }
        }

        if ($_POST['op'] == 'buscarNombre') {
            $datos = $persona->buscarNombre($_POST['nombre']);
            foreach ($datos as $registro) {
                $datos_persona = json_decode($registro['datos'], true);
                $estado = $datos_persona['estado'] == 1 ? 'Activo' : $datos_persona['estado'];
                echo "
                <tr>
                    <td class='p-3' data-label='#'>{$registro['id']}</td>
                    <td class='p-3' data-label='Apellidos'>{$datos_persona['apellidos']}</td>
                    <td class='p-3' data-label='Nombre'>{$datos_persona['nombre']}</td>
                    <td class='p-3' data-label='Documento'>{$datos_persona['documento']}</td>
                    <td class='p-3' data-label='Fecha de Nacimiento'>{$datos_persona['fechaNacimiento']}</td>
                    <td class='p-3' data-label='Teléfono'>{$datos_persona['telefono']}</td>
                    <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                    <td data-label='Acciones'>
                    <div class='btn-group' role='group'>
                      <button type='button' id='editar-boton' data-id='{$registro['id']}' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                      <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                    </div>
                  </td>
                </tr>
                ";
            }
        }

        if ($_POST['op'] == 'buscarDocumento') {
            $datos = $persona->buscarDocumento($_POST['documento']);
            foreach ($datos as $registro) {
                $datos_persona = json_decode($registro['datos'], true);
                $estado = $datos_persona['estado'] == 1 ? 'Activo' : $datos_persona['estado'];
                echo "
                <tr>
                    <td class='p-3' data-label='#'>{$registro['id']}</td>
                    <td class='p-3' data-label='Apellidos'>{$datos_persona['apellidos']}</td>
                    <td class='p-3' data-label='Nombre'>{$datos_persona['nombre']}</td>
                    <td class='p-3' data-label='Documento'>{$datos_persona['documento']}</td>
                    <td class='p-3' data-label='Fecha de Nacimiento'>{$datos_persona['fechaNacimiento']}</td>
                    <td class='p-3' data-label='Teléfono'>{$datos_persona['telefono']}</td>
                    <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                    <td data-label='Acciones'>
                    <div class='btn-group' role='group'>
                      <button type='button' id='editar-boton' data-id='{$registro['id']}' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                      <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                    </div>
                  </td>
                </tr>
                ";
            }
        }

        if ($_POST['op'] == 'buscarfechaNacimiento') {
            $datos = $persona->buscarfechaNacimiento($_POST['fechaNacimiento']);
            foreach ($datos as $registro) {
                $datos_persona = json_decode($registro['datos'], true);
                $estado = $datos_persona['estado'] == 1 ? 'Activo' : $datos_persona['estado'];
                echo "
                <tr>
                    <td class='p-3' data-label='#'>{$registro['id']}</td>
                    <td class='p-3' data-label='Apellidos'>{$datos_persona['apellidos']}</td>
                    <td class='p-3' data-label='Nombre'>{$datos_persona['nombre']}</td>
                    <td class='p-3' data-label='Documento'>{$datos_persona['documento']}</td>
                    <td class='p-3' data-label='Fecha de Nacimiento'>{$datos_persona['fechaNacimiento']}</td>
                    <td class='p-3' data-label='Teléfono'>{$datos_persona['telefono']}</td>
                    <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                    <td data-label='Acciones'>
                    <div class='btn-group' role='group'>
                      <button type='button' id='editar-boton' data-id='{$registro['id']}' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                      <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                    </div>
                  </td>
                </tr>
                ";
            }
        }

        if ($_POST['op'] == 'buscarTelefono') {
            $datos = $persona->buscarTelefono($_POST['telefono']);
            foreach ($datos as $registro) {
                $datos_persona = json_decode($registro['datos'], true);
                $estado = $datos_persona['estado'] == 1 ? 'Activo' : $datos_persona['estado'];
                echo "
                <tr>
                    <td class='p-3' data-label='#'>{$registro['id']}</td>
                    <td class='p-3' data-label='Apellidos'>{$datos_persona['apellidos']}</td>
                    <td class='p-3' data-label='Nombre'>{$datos_persona['nombre']}</td>
                    <td class='p-3' data-label='Documento'>{$datos_persona['documento']}</td>
                    <td class='p-3' data-label='Fecha de Nacimiento'>{$datos_persona['fechaNacimiento']}</td>
                    <td class='p-3' data-label='Teléfono'>{$datos_persona['telefono']}</td>
                    <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                    <td data-label='Acciones'>
                    <div class='btn-group' role='group'>
                      <button type='button' id='editar-boton' data-id='{$registro['id']}' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                      <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                    </div>
                  </td>
                </tr>
                ";
            }
        }

        if ($_POST['op'] == 'buscarEstado') {
          $datos = $persona->buscarEstado($_POST['estado']);
          foreach ($datos as $registro) {
              $datos_persona = json_decode($registro['datos'], true);
              $estado = $datos_persona['estado'] == 1 ? 'Activo' : $datos_persona['estado'];
              echo "
              <tr>
                  <td class='p-3' data-label='#'>{$registro['id']}</td>
                  <td class='p-3' data-label='Apellidos'>{$datos_persona['apellidos']}</td>
                  <td class='p-3' data-label='Nombre'>{$datos_persona['nombre']}</td>
                  <td class='p-3' data-label='Documento'>{$datos_persona['documento']}</td>
                  <td class='p-3' data-label='Fecha de Nacimiento'>{$datos_persona['fechaNacimiento']}</td>
                  <td class='p-3' data-label='Teléfono'>{$datos_persona['telefono']}</td>
                  <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>$estado</span></td>
                  <td data-label='Acciones'>
                  <div class='btn-group' role='group'>
                    <button type='button' id='editar-boton' data-id='{$registro['id']}' class='btn btn-outline-warning btn-sm editar-btn'><i class='fa-solid fa-pencil'></i></button>
                    <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                  </div>
                </td>
              </tr>
              ";
          }
      }

        if ($_POST['op'] == 'eliminar') {
            $persona->eliminar($_POST['id']);
        }

        if ($_POST['op'] == 'obtenerDatos') {
            $datos = $persona->obtenerDatos($_POST['id']);
            echo json_encode($datos);
        }

    }

?>