<?php       

    require_once 'conexion.php';

    class Persona extends Conexion{
        private $conexion;

        public function __construct()
        {
            $this->conexion = parent::getConexion();
        }

        public function listar() {
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM persona WHERE JSON_EXTRACT(datos, '$.estado') = 1");
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
                
                $datos = array();
                foreach ($resultados as $resultado) {
                    $dato = json_decode($resultado['datos'], true);
                    $dato['id'] = $resultado['id'];
                    $datos[] = $dato;
                }
                
                return $datos;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        
        public function  listarPersonas(){
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM persona WHERE JSON_EXTRACT(datos,'$.estado') = 1");
                $consulta->execute();
                $tabla = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $tabla;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function obtenerTipoDocumento($idTipoDocumento){
            try {
                $consulta =$this->conexion->prepare("SELECT id,datos from tipoDocumento where id = ? AND JSON_EXTRACT(datos, '$.estado') = 1");
                $consulta->execute(array($idTipoDocumento));
                $resultado = $consulta->fetch();
                $datos = json_decode($resultado['datos'], true);
                $datos['id'] = $resultado['id'];
                return $datos;
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        public function registrarPersonas($apellidos, $nombre, $idTipoDocumento,  $documento, $fechaNacimiento, $telefono){
            try {
                $datos = json_encode(array(
                    'apellidos' => $apellidos,
                    'nombre' => $nombre,
                    'idTipoDocumento' => $idTipoDocumento,
                    'documento' => $documento,
                    'fechaNacimiento' => $fechaNacimiento,
                    'telefono' => $telefono,
                    'estado' => 1
                ));
                $consulta = $this->conexion->prepare("INSERT INTO persona(datos)  VALUES (:datos)");
                $consulta->bindParam(':datos', $datos, PDO::PARAM_STR);
                $consulta->execute();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function editarPersona($apellidos, $nombre, $idTipoDocumento,  $documento, $fechaNacimiento, $telefono, $estado, $idpersona){
            try {
                $datos = json_encode(array(
                    'apellidos' => $apellidos,
                    'nombre' => $nombre,
                    'idTipoDocumento' => $idTipoDocumento,
                    'documento' => $documento,
                    'fechaNacimiento' => $fechaNacimiento,
                    'telefono' => $telefono,
                    'estado' => $estado,
                ));
                $consulta = $this->conexion->prepare("UPDATE persona SET datos = JSON_SET(datos, '$.apellidos', ?, '$.nombre', ?, '$.idTipoDocumento', ?, '$.documento', ?, '$.fechaNacimiento', ?, '$.telefono', ?, '$.estado', ?) WHERE id = ?");
                $consulta->execute([$apellidos, $nombre, $idTipoDocumento, $documento, $fechaNacimiento, $telefono, $estado, $idpersona]);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function eliminar($idpersona){
            try {
                $consulta = $this->conexion->prepare("UPDATE persona SET datos = JSON_REPLACE(datos, '$.estado','0') WHERE id = ?");
                $consulta->execute(array($idpersona));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function obtenerDatos($idpersona) {
            try {
                $consulta = $this->conexion->prepare("SELECT id, datos FROM persona WHERE id = ?");
                $consulta->execute(array($idpersona));
                $resultado = $consulta->fetch();
                $datos = json_decode($resultado['datos'], true);
                $datos['id'] = $resultado['id'];
                return $datos;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function buscarApellido($apellidos){
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM persona WHERE 
                (JSON_EXTRACT(datos, '$.apellidos') LIKE CONCAT('%', ?, '%'));");
                $consulta->execute(array($apellidos));
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function buscarNombre($nombre){
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM persona WHERE 
                (JSON_EXTRACT(datos, '$.nombre') LIKE CONCAT('%', ?, '%'));");
                $consulta->execute(array($nombre));
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function buscarDocumento($documento){
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM persona WHERE 
                (JSON_EXTRACT(datos, '$.documento') LIKE CONCAT('%', ?, '%'));");
                $consulta->execute(array($documento));
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function buscarfechaNacimiento($fechaNacimiento){
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM persona WHERE 
                (JSON_EXTRACT(datos, '$.fechaNacimiento') LIKE CONCAT('%', ?, '%'));");
                $consulta->execute(array($fechaNacimiento));
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function buscarTelefono($telefono){
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM persona WHERE 
                (JSON_EXTRACT(datos, '$.telefono') LIKE CONCAT('%', ?, '%'));");
                $consulta->execute(array($telefono));
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function buscarEstado($estado){
            try {
                $consulta = $this->conexion->prepare("SELECT * FROM persona WHERE 
                (JSON_EXTRACT(datos, '$.estado') LIKE CONCAT('%', ?, '%'));");
                $consulta->execute(array($estado));
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

    }

?>