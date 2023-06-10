<?php
    session_start();
    require_once '../models/empresa.php';

    if (isset($_POST['op'])) {
        $empresa = new Empresa();

        if ($_POST['op'] == 'listarEmpresa') {
            $datos = $empresa->listarEmpresa();
            foreach ($datos as $registro) {
                $datos_empresa = json_decode($registro['datos'], true);
                $estado = $datos_empresa['estado'] == 1 ? 'Activo' : $datos_empresa['estado'];
                $tipoDocumentoMap = [
                    1 => "DNI",
                    2 => "RUC",
                    3 => "PASAPORTE"
                ];
                $tipoDocumento = $tipoDocumentoMap[$datos_empresa['idTipoDocumento']] ?? 'Desconocido';
                echo "
                <tr>
                    <td class='p-3' data-label='#'>{$registro['id']}</td>
                    <td class='p-3' data-label='Nombre'>{$datos_empresa['nombre']}</td>
                    <td class='p-3' data-label='Tipo de Documento'>$tipoDocumento</td>
                    <td class='p-3' data-label='Documento'>{$datos_empresa['documento']}</td>
                    <td class='p-3' data-label='Nombre Comercial'>{$datos_empresa['nombreComercial']}</td>
                    <td class='p-3' data-label='Fecha de Registro'>{$datos_empresa['fechaRegistro']}</td>
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

        if ($_POST['op'] == 'registrarEmpresa') {
            $nombre = $_POST['nombre'];
            $idTipoDocumento = $_POST['idTipoDocumento'];
            $documento = $_POST['documento'];
            $nombreComercial = $_POST['nombreComercial'];
            $estado = $_POST['estado'];
            $empresa->registrarEmpresa($nombre, $idTipoDocumento, $documento, $nombreComercial, $estado);
        }

        if ($_POST['op'] == 'obtenerDatos') {
            $datos = $empresa->obtenerDatos($_POST['id']);
            echo json_encode($datos);
        }

        if ($_POST['op'] == 'editarEmpresa') {
            $nombre = $_POST['nombre'];
            $idTipoDocumento = $_POST['idTipoDocumento'];
            $documento = $_POST['documento'];
            $nombreComercial = $_POST['nombreComercial'];
            $estado = $_POST['estado'];
            $idempresa = $_POST['id'];
            $empresa->editarEmpresa($nombre, $idTipoDocumento, $documento, $nombreComercial, $estado,$idempresa);
        }

    }

?>