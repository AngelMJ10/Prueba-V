<?php

    require_once 'conexion.php';

    class Empresa extends Conexion{
        private $conexion;

        public function __construct()
        {
            $this->conexion= parent::getConexion();
        }

        public function listarEmpresa(){
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM empresa WHERE JSON_EXTRACT(datos,'$.estado') = 1");
                $consulta->execute();
                $tabla = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $tabla;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function registrarEmpresa($nombre, $idTipoDocumento,  $documento, $nombreComercial, $estado){
            try {
                $fecha = date('Y-m-d'); // Obtiene la fecha actual
                $hora = date('H:i:s'); // Obtiene la hora actual
                $datos = json_encode(array(
                    'nombre' => $nombre,
                    'idTipoDocumento' => $idTipoDocumento,
                    'documento' => $documento,
                    'nombreComercial' => $nombreComercial,
                    'estado' => $estado,
                    'fechaRegistro' => $fecha,
                    'hora' => $hora
                ));

                $consulta  =$this->conexion->prepare("INSERT INTO empresa (datos) values (:datos)");
                $consulta->bindParam(':datos', $datos, PDO::PARAM_STR);
                $consulta->execute();
            } catch (Exception $e) {
                $respuesta = array(
                    "error" => true,
                    "mensaje" => $e->getMessage()
                );
                return $respuesta;
            }
        }

        public function obtenerDatos($idempresa) {
            try {
                $consulta = $this->conexion->prepare("SELECT id, datos FROM empresa WHERE id = ?");
                $consulta->execute(array($idempresa));
                $resultado = $consulta->fetch();
                $datos = json_decode($resultado['datos'], true);
                $datos['id'] = $resultado['id'];
                return $datos;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function editarEmpresa($nombre, $idTipoDocumento, $documento,  $nombreComercial, $estado, $idempresa){
            try {
                $consulta = $this->conexion->prepare("UPDATE empresa SET datos = JSON_SET(datos, '$.nombre', ?, '$.idTipoDocumento', ?, '$.documento', ?, '$.nombreComercial', ?, '$.estado', ?) WHERE id = ?");
                $consulta->execute([$nombre, $idTipoDocumento, $documento, $nombreComercial, $estado, $idempresa]);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

    }

?>