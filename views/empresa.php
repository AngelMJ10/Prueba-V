<?php
session_start();

//Si no existe la sessión
if (!isset($_SESSION['login']) || $_SESSION['login'] == false){
    header("Location:../index.php");
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/24503cbed7.js" crossorigin="anonymous"></script>
    <title>Empresas</title>
</head>
<body>
<link rel="stylesheet" href="../styles/persona.css">
<style>
    body {
      background-image: url("../img/logos\ vamas_Mesa\ de\ trabajo\ 1\ copia\ 2.png");
      background-repeat: no-repeat;
      background-size: 50%;
      background-position: center ;
      opacity: 0.9;
    }
</style>

  <div class="capa text-center">
    <h1>Empresas</h1>
  </div>
  <div class="container py-5">
    <!-- Navs -->
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="listar-tab" data-bs-toggle="tab" href="#listar" role="tab" aria-controls="listar" aria-selected="true">Listar</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="registrar-tab" data-bs-toggle="tab" href="#registrar" role="tab" aria-controls="registrar" aria-selected="false">Registrar</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" id="editar-tab" data-bs-toggle="tab" href="#editar" role="tab" aria-controls="contact" aria-selected="false">Editar</a>
      </li> -->
    </ul>

    <!-- Tabs -->
    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade show active" id="listar" role="tabpanel" aria-labelledby="listar-tab">

        <div class="accordion" id="acordion1">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filtros" aria-expanded="true" aria-controls="collapseOne">
                Filtros
              </button>
            </h2>
            <div id="filtros" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#acordion1">
              <div class="accordion-body">
                <form>
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="apellidos-buscar" name="apellidos" placeholder="Apellidos">
                          <label for="apellidos" class="form-label">Apellidos</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="nombre-buscar" placeholder="Nombre" name="nombre">
                          <label for="nombre" class="form-label">Nombre</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3">
                          <select name="tipoDocumento" id="tipoDocumento-buscar" class="form-control form-control-sm">
                            <label for="tipoDocumento">Seleccione el tipo de Documento:</label>
                            <option value="">Seleccione</option>
                            <option value="1">DNI</option>
                            <option value="2">RUC</option>
                            <option value="3">Pasaporte</option>
                          </select>
                      </div>
                    </div>
                      
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4">
                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="documento-buscar" placeholder="Documento" name="documento">
                        <label for="documento" class="form-label">Documento</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3">
                        <input type="date" class="form-control" placeholder="Fecha de Nacimiento" id="fecha-nacimiento-buscar" name="fechare">
                        <label form="fecha" class="form-label">Fecha de Nacimiento</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3">
                          <input type="number" class="form-control" id="telefono-buscar" placeholder="Teléfono" name="telefono">
                          <label for="telefono" class="form-label">Teléfono</label>
                      </div>
                    </div>                
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4">
                      <div class="form-floating mb-3">
                        <select name="estado" id="estado-buscar" class="form-control form-control-sm">
                          <label for="estado" class="form-label">Estado</label>
                          <option value="">Seleccione</option>
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                        </select>
                      </div>
                    </div>

                  </div>

                  <button type="button" id="buscar" class="btn btn-outline-primary">Agregar</button>
                  <button type="button" data-bs-toggle="modal" data-bs-target="#modalEditar" class="btn btn-outline-success">Editar</button>

                </form>
              </div>
            </div>
          </div>
        </div>
        
        <div class="table-responsive mt-3" id="tabla-empresa">
          <table class="table table-hover"> 

              <thead>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Tipo de Documento</th>
                  <th>Documento</th>
                  <th>Nombre Comercial</th>
                  <th>Fecha de Registro</th>
                  <th>Estado</th>
                  <th>Acción</th>
              </thead>

              <tbody>
              </tbody>
          
            </table>
        </div>
      </div>

      <div class="tab-pane fade mb-5" id="registrar" role="tabpanel" aria-labelledby="registrar-tab">
        <div class="card shadow-lg border-0">
            <div class="card-header text-white capa-listar py-3" style="background: #005478">
              <h4 class="card-title mb-0">Agregar nuevo registro <i class="bi bi-universal-access"></i></h4>
            </div>
            <div class="card-body">
              <form>
                <div class="row mb-2 mt-2">
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre">
                            <label for="nombre" class="form-label">Nombre</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <select name="tipoDocumento" id="tipoDocumento" class="form-control form-control-sm">
                              <label for="tipoDocumento">Seleccione el tipo de Documento:</label>
                              <option value="">Seleccione</option>
                              <option value="1">DNI</option>
                              <option value="2">RUC</option>
                              <option value="3">Pasaporte</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="documento" placeholder="Documento" name="documento">
                      <label for="documento" class="form-label">Documento</label>
                    </div>
                  </div>
                    
                </div>

                <div class="row mb-3">

                  <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nombreComercial" placeholder="Nombre Comercial" name="nombreComercial">
                      <label for="nombreComercial" class="form-label">Nombre Comercial</label>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-floating mb-3">
                      <select name="estado" id="estado" class="form-control form-control-sm">
                        <label for="estado" class="form-label">Estado</label>
                        <option value="">Seleccione</option>
                        <option value="1">Activo</option>
                      </select>
                    </div>
                  </div>
                  
                </div>

                <button type="button" id="registrar-datos" class="btn btn-outline-primary">Agregar</button>

              </form>
            </div>
        </div>
      </div>

    </div>

  </div>


<!-- Modal -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header text-light" style='background-color: #005478;'>
        <h1 class="modal-title fs-5" id="modalEditarLabel">Editar Datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row mb-3">
            <div class="col-md-4">
              <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="nombre-editar" placeholder="Nombre" name="nombre">
                  <label for="nombre" class="form-label">Nombre</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating mb-3">
                  <select name="tipoDocumento" id="tipoDocumento-editar" class="form-control form-control-sm">
                    <label for="tipoDocumento">Seleccione el tipo de Documento:</label>
                    <option value="">Seleccione</option>
                    <option value="1">DNI</option>
                    <option value="2">RUC</option>
                    <option value="3">Pasaporte</option>
                  </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating mb-3">
                <input type="number" class="form-control" id="documento-editar" placeholder="Documento" name="documento">
                <label for="documento" class="form-label">Documento</label>
              </div>
            </div>
              
          </div>

          <div class="row mb-3">
            
            <div class="col-md-4">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" placeholder="NombreComercial" id="nombreComercial-editar" name="nombreComercial">
                <label form="nombreComercial" class="form-label">nombreComercial</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating mb-3">
                <select name="estado" id="estado-editar" class="form-control form-control-sm">
                  <label for="estado" class="form-label">Estado</label>
                  <option value="">Seleccione</option>
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div> 
            
            <div class="col-md-4">
              <div class="form-floating mb-3">
                <input type="number" disabled class="form-control" id="id-editar" placeholder="ID" name="id">
                <label for="id-editar" class="form-label">ID</label>
              </div>
            </div>

          </div>

          <button type="button" id="editar-datos" class="btn btn-outline-primary">Editar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../controllers/empresa.php',
                type: 'POST',
                data: 'op=listarEmpresa',
                success: function(result){
                    $("#tabla-empresa tbody").html(result);
                }
            });
        });

        function registrarEmpresa(){
          if (confirm("¿Está seguro de guardar estos datos?")){

            //Array asociativo en JS, que guarda todos los parámetros que el
            //controlador está esperando (son 7 datos = 1 operacion + 6 valores de producto)
            let datos = {
                'op'                    : 'registrarEmpresa',
                'nombre'                : $("#nombre").val(),
                'idTipoDocumento'       : $("#tipoDocumento").val(),
                'documento'             : $("#documento").val(),
                'nombreComercial'       : $("#nombreComercial").val(),
                'estado'                : $("#estado").val()
            };

            $.ajax({
                url: '../controllers/empresa.php',
                type: 'POST',
                data: datos,
                success: function (result){
                    if (result == ""){
                        alert("Grabado correctamente.");
                        location.reload();
                    }
                }
            });
          }
        }

        function editarDatos(){
          if (confirm("¿Está seguro de editar estos datos?")){

            //Array asociativo en JS, que guarda todos los parámetros que el
            //controlador está esperando (son 7 datos = 1 operacion + 6 valores de producto)
            let datos = {
                'op'                    : 'editarEmpresa',
                'nombre'                : $("#nombre-editar").val(),
                'idTipoDocumento'       : $("#tipoDocumento-editar").val(),
                'documento'             : $("#documento-editar").val(),
                'nombreComercial'       : $("#nombreComercial-editar").val(),
                'estado'                : $("#estado-editar").val(),
                'id'                    : $("#id-editar").val()
            };

            $.ajax({
                url: '../controllers/empresa.php',
                type: 'POST',
                data: datos,
                success: function (result){
                    if (result == ""){
                        alert("Grabado correctamente.");
                        location.reload();
                    }
                }
            });
          }
        }

        $("#myTabContent").on("click", ".editar-btn",function(){
          let id = $(this).data("id");
          $.ajax({
            url: '../controllers/empresa.php',
            type: 'POST',
            data: 'op=obtenerDatos&id=' + id,
            success: function(result){
              let registro = JSON.parse(result);
              if (registro) {
                $("#nombre-editar").val(registro['nombre']);
                $("#tipoDocumento-editar").val(registro['idTipoDocumento']);
                $("#documento-editar").val(registro['documento']);
                $("#nombreComercial-editar").val(registro['nombreComercial']);
                $("#estado-editar").val(registro['estado']);
                $("#id-editar").val(registro['id']);
                $("#modalEditar").modal('show');
              }
            }
          });
        })

        $("#registrar-datos").click(registrarEmpresa);
        $("#editar-datos").click(editarDatos);

    </script>
    
</body>
</html>