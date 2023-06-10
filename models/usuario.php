<?php       
  require_once 'conexion.php';

  class Usuario extends Conexion{
    private $conexion;

    public function __construct(){
        $this->conexion = parent::getConexion();
    }
    
    public function login($correo){
      try {
        $consulta = $this->conexion->prepare("SELECT * FROM usuario WHERE(JSON_EXTRACT (datos,'$.correo') =  ?)");
        $consulta->execute(array($correo));
        $respuesta = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $respuesta;
      } catch (Exception $e) {
        $respuesta = array(
          "error" => true,
          "mensaje" => $e->getMessage()
        );
        return $respuesta;
      }
    }

    public function listar(){
      try {
          $consulta = $this->conexion->prepare("SELECT * FROM usuario WHERE JSON_EXTRACT(datos , '$.equipo') = 0");
          $consulta->execute();
          $tabla = $consulta->fetchAll(PDO::FETCH_ASSOC);
          return $tabla;
      } catch (Exception $e) {
          die($e->getMessage());
      }
    }

    public function registrarUsuario($idPersona, $correo,  $clave, $user, $cargo, $direccion){
      try {
          $datos = json_encode(array(
              'idPersona' => $idPersona,
              'correo' => $correo,
              'clave' => $clave,
              'user' => $user,
              'cargo' => $cargo,
              'direccion' => $direccion,
              'estado' => 1,
              "equipo" => 0
          ));
          $consulta = $this->conexion->prepare("INSERT INTO usuario(datos)  VALUES (:datos)");
          $consulta->bindParam(':datos', $datos, PDO::PARAM_STR);
          $consulta->execute();
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
      
    public function obtenerDatos($idUsuario){
      try {
        $consulta = $this->conexion->prepare("SELECT id, datos FROM usuario WHERE id = ?");
        $consulta->execute(array($idUsuario));
        $resultado = $consulta->fetch();
        $datos = json_decode($resultado['datos'], true);
        $datos['id'] = $resultado['id'];
        return $datos;
      } catch (Exception $e) {
        die($e->getMessage());
      } 
    }

  }

?>