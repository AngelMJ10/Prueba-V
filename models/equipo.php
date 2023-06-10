<?php

    require_once 'conexion.php';

    class Equipo extends Conexion{
        private $conexion;

        public function __construct()
        {
            $this->conexion= parent::getConexion();
        }

        public function listar(){
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM equipo WHERE JSON_EXTRACT(datos,'$.estado') = 1");
                $consulta->execute();
                $tabla = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $tabla;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function registrarEquipo($nombre, $estado){
            try {
                $fecha = date('Y-m-d'); // Obtiene la fecha actual
                $hora = date('H:i:s'); // Obtiene la hora actual
                $datos = json_encode(array(
                    'nombre' => $nombre,
                    'integrantes' => [],
                    'fechaRegistro' => $fecha,
                    'hora' => $hora,
                    'estado' => $estado,
                ));

                $consulta  =$this->conexion->prepare("INSERT INTO equipo (datos) values (:datos)");
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

        public function obtenerDatos($idEquipo) {
            try {
                $consulta = $this->conexion->prepare("SELECT id, datos FROM equipo WHERE id = ?");
                $consulta->execute(array($idEquipo));
                $resultado = $consulta->fetch();
                $datos = json_decode($resultado['datos'], true);
                $datos['id'] = $resultado['id'];
                return $datos;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function registrarIntegrante($idUsuario, $idIntegrante, $idEquipo) {
            try {
                $fecha = date('Y-m-d'); // Obtiene la fecha actual
                $hora = date('H:i:s'); // Obtiene la hora actual
                
                $consulta = $this->conexion->prepare("UPDATE equipo SET datos = JSON_ARRAY_APPEND(datos, '$.integrantes', JSON_OBJECT(
                    'idUsuario', ?,
                    'idIntegrante', ?,
                    'fechaRegistro', ?,
                    'horaRegistro', ?,
                    'fechaSalida', '',
                    'horaSalida', '',
                    'estado', '1',
                    'disponible', '1'
                ))  WHERE id = ?");
                
                $consulta->execute([$idUsuario, $idIntegrante, $fecha, $hora, $idEquipo]);
                
                $respuesta = array(
                    "error" => false,
                    "mensaje" => "Integrante registrado correctamente"
                );
            } catch (Exception $e) {
                $respuesta = array(
                    "error" => true,
                    "mensaje" => $e->getMessage()
                );
            }
            
            return $respuesta;
        }      

        public function asignarEquipo($idEquipo, $idUsuario){
            try {
                $consulta = $this->conexion->prepare("UPDATE usuario SET datos = JSON_SET(datos , '$.equipo' , ?) WHERE id = ?");
                $consulta->execute([$idEquipo , $idUsuario]);
                $respuesta = array(
                    "error" => false,
                    "mensaje" => "Equipo asignado correctamente correctamente"
                );
            } catch (Exception $e) {
                $respuesta = array(
                    "error" => true,
                    "mensaje" => $e->getMessage()
                );
            }
            return $respuesta;
        }

        public function obtenerTipoDocumento($idTipoDocumento){
            try {
                $consulta =$this->conexion->prepare("SELECT id,datos from tipoDocumento where id = ? AND JSON_EXTRACT(datos, '$.estado') = = 1");
                $consulta->execute(array($idTipoDocumento));
                $resultado = $consulta->fetch();
                $datos = json_decode($resultado['datos'], true);
                $datos['id'] = $resultado['id'];
                return $datos;
            } catch (Exception $e) {
                $respuesta = array(
                    "error" => true,
                    "mensaje" => $e->getMessage());
            }
            return  $respuesta;
        }

        public function eliminarIntegrante($idEquipoParam, $indice) {
            try {
                $consulta = $this->conexion->prepare("UPDATE equipo SET datos = JSON_SET(datos, '$.integrantes', JSON_REMOVE(JSON_EXTRACT(datos, '$.integrantes'), ?)) WHERE id = ?");
                $consulta->execute([$indice, $idEquipoParam]);
    
                $respuesta = array(
                    "error" => false,
                    "mensaje" => "Integrante eliminado correctamente"
                );
            } catch (Exception $e) {
                $respuesta = array(
                    "error" => true,
                    "mensaje" => $e->getMessage()
                );
            }
    
            return $respuesta;
        }

        public function asignarFechaSalida($idEquipo){
            $fechaSalida = date('Y-m-d');
            try {
                $consulta = $this->conexion->prepare("UPDATE equipo SET datos = JSON_SET(datos, '$.integrantes[0].fechaSalida', ?) WHERE id = ?");
                $consulta->execute([$fechaSalida,$idEquipo]);
                $respuesta = array(
                    "error" => false,
                    "mensaje" => "Fecha asignada correctamente"
                );
            } catch (Exception $e) {
                $respuesta = array(
                    "error" => true,
                    "mensaje" => $e->getMessage()
                );
            }
        }

        public function asignarHoraSalida($idEquipo){
            $horaSalida = date('Y-m-d');
            try {
                $consulta = $this->conexion->prepare("UPDATE equipo SET datos = JSON_SET(datos, '$.integrantes[0].horaSalida', ?) WHERE id = ?");
                $consulta->execute([$horaSalida,$idEquipo]);
                $respuesta = array(
                    "error" => false,
                    "mensaje" => "Hora asignada correctamente"
                );
            } catch (Exception $e) {
                $respuesta = array(
                    "error" => true,
                    "mensaje" => $e->getMessage()
                );
            }
        }

        public function obtenerIntegrantesPorEstado($idEquipo) {
            try {
                $consulta = $this->conexion->prepare("SELECT id,datos FROM equipo WHERE id = ?");
                $consulta->execute([$idEquipo]);
                $equipo = $consulta->fetch(PDO::FETCH_ASSOC);
                $datos = json_decode($equipo['datos'], true);
                $integrantes = $datos['integrantes'];
                $integrantesFiltrados = array_filter($integrantes, function($integrante) {
                    return $integrante['estado'] == 1;
                });
                $datos['integrantes'] = $integrantesFiltrados;
                return $datos;
            } catch (Exception $e) {
                die($e->getMessage());
            }
            
        }
        
        public function cambiarEstadoIntegrante($idUsuario, $idEquipo) {
            try {
                $nuevoEstado = 0;
                
                $consulta = $this->conexion->prepare("SELECT id, datos FROM equipo WHERE id = ?");
                $consulta->execute([$idEquipo]);
                $equipo = $consulta->fetch(PDO::FETCH_ASSOC);
        
                if ($equipo) {
                    $datos = json_decode($equipo['datos'], true);
                    $integrantes = $datos['integrantes'];
        
                    foreach ($integrantes as &$integrante) {
                        if ($integrante['idUsuario'] == $idUsuario) {
                            $integrante['estado'] = $nuevoEstado;
                        }
                    }
        
                    $datos['integrantes'] = $integrantes;
                    $datosJson = json_encode($datos);
        
                    // Actualizar los datos en la base de datos
                    $consulta = $this->conexion->prepare("UPDATE equipo SET datos = ? WHERE id = ?");
                    $consulta->execute([$datosJson, $equipo['id']]);
                } else {
                    echo "El equipo con ID $idEquipo no existe.";
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function cambiarFechaSalida($idUsuario, $idEquipo) {
            try {
                $fechaSalida = date('Y-m-d');
                $consulta = $this->conexion->prepare("SELECT id, datos FROM equipo WHERE id = ?");
                $consulta->execute([$idEquipo]);
                $equipo = $consulta->fetch(PDO::FETCH_ASSOC);
        
                if ($equipo) {
                    $datos = json_decode($equipo['datos'], true);
                    $integrantes = $datos['integrantes'];
        
                    foreach ($integrantes as &$integrante) {
                        if ($integrante['idUsuario'] == $idUsuario) {
                            $integrante['fechaSalida'] = $fechaSalida;
                        }
                    }
        
                    $datos['integrantes'] = $integrantes;
                    $datosJson = json_encode($datos);
        
                    // Actualizar los datos en la base de datos
                    $consulta = $this->conexion->prepare("UPDATE equipo SET datos = ? WHERE id = ?");
                    $consulta->execute([$datosJson, $equipo['id']]);
                } else {
                    echo "El equipo con ID $idEquipo no existe. ATTE: cambiarFechaSalida.";
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function cambiarHoraSalida($idUsuario,$idEquipo) {
            try {
                $horaSalida = date('H:i:s');
                $consulta = $this->conexion->prepare("SELECT id, datos FROM equipo WHERE id = ?");
                $consulta->execute([$idEquipo]);
                $equipo = $consulta->fetch(PDO::FETCH_ASSOC);
        
                if ($equipo) {
                    $datos = json_decode($equipo['datos'], true);
                    $integrantes = $datos['integrantes'];
        
                    foreach ($integrantes as &$integrante) {
                        if ($integrante['idUsuario'] == $idUsuario) {
                            $integrante['horaSalida'] = $horaSalida;
                        }
                    }
        
                    $datos['integrantes'] = $integrantes;
                    $datosJson = json_encode($datos);
        
                    // Actualizar los datos en la base de datos
                    $consulta = $this->conexion->prepare("UPDATE equipo SET datos = ? WHERE id = ?");
                    $consulta->execute([$datosJson, $equipo['id']]);
                } else {
                    echo "El equipo con ID $idEquipo no existe.ATTE: CambiarHora Salida";
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    
        public function quitarEquipo($idUsuario){
            try {
                $idEquipo = 0;
                $consulta = $this->conexion->prepare("UPDATE usuario SET datos = JSON_SET(datos , '$.equipo' , ?) WHERE id = ?");
                $consulta->execute([$idEquipo , $idUsuario]);
                $respuesta = array(
                    "error" => false,
                    "mensaje" => "Equipo asignado correctamente correctamente"
                );
            } catch (Exception $e) {
                $respuesta = array(
                    "error" => true,
                    "mensaje" => $e->getMessage()
                );
            }
            return $respuesta;
        }

    }

?>