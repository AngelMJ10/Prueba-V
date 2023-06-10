function obtenerDatos(id) {
    const modal = document.querySelector("#modalEditar");
    const apellidosEditar = document.querySelector("#apellidos-editar");
    const nombreEditar = document.querySelector("#nombre-editar");
    const tipoDocumentoEditar = document.querySelector("#tipoDocumento-editar");
    const documentoEditar = document.querySelector("#documento-editar");
    const fechaNacimientoEditar = document.querySelector("#fecha-nacimiento-editar");
    const telefonoEditar = document.querySelector("#telefono-editar");
  
    const parametrosURL = new URLSearchParams();
    parametrosURL.append("op", "obtenerDatos");
    parametrosURL.append("id", id);
  
    fetch('../controllers/persona.php', {
      method: 'POST',
      body: parametrosURL
    })
    .then(respuesta => {
      if (respuesta.ok) {
        return respuesta.json();
      } else {
        throw new Error('Error en la solicitud');
      }
    })
    .then(datos => {
      apellidosEditar.value = datos.apellidos;
      nombreEditar.value = datos.nombre;
      tipoDocumentoEditar.value = datos.idTipoDocumento;
      documentoEditar.value = datos.documento;
      fechaNacimientoEditar.value = datos.fechaNacimiento;
      telefonoEditar.value = datos.telefono;
  
      const bootstrapModal = new bootstrap.Modal(modal);
      bootstrapModal.show();
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

document.addEventListener("DOMContentLoaded", () => {

    function listar() {
        const tabla = document.querySelector("#tabla-persona");
        const bodyTable = tabla.querySelector("tbody");

        const parametrosURL = new URLSearchParams();
        parametrosURL.append("op", "listar");

        fetch('../controllers/persona.php', {
            method: 'POST',
            body: parametrosURL
        })
        .then(respuesta => {
            if (respuesta.ok) {
                return respuesta.json();
            } else {
                throw new Error('Error en la solicitud');
            }
        })
        .then(datos => {
            datos.forEach(element => {
                let fila = `
                            <tr>
                                <td class='p-3' data-label='#'>${element.id}</td>
                                <td class='p-3' data-label='Apellidos'>${element.apellidos}</td>
                                <td class='p-3' data-label='Nombre'>${element.nombre}</td>
                                <td class='p-3' data-label='Documento'>${element.documento}</td>
                                <td class='p-3' data-label='Fecha de Nacimiento'>${element.fechaNacimiento}</td>
                                <td class='p-3' data-label='Teléfono'>${element.telefono}</td>
                                <td class='p-3' data-label='Estado'><span class='badge rounded-pill' style='background-color: #005478'>${element.estado}</span></td>
                                <td data-label='Acciones'>
                                <div class='btn-group' role='group'>
                                <button type="button" id="editar-boton" data-id="${element.id}" onclick="obtenerDatos(${element.id})" class="btn btn-outline-warning btn-sm editar-btn"><i class="fa-solid fa-pencil"></i></button>
                                <button type='button' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-file-pdf'></i></button>
                                </div>
                                </td>
                            </tr>
                        `;
                bodyTable.innerHTML += fila;
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function registrar() {
        const apellido = document.querySelector("#apellidos").value;
        const nombre = document.querySelector("#nombre").value;
        const tipoDocumento = document.querySelector("#tipoDocumento").value;
        const documento = document.querySelector("#documento").value;
        const fechaNacimiento = document.querySelector("#fecha-nacimiento").value;
        const telefono = document.querySelector("#telefono").value;
    
        // Mostrar alerta de confirmación
        const confirmacion = confirm("¿Estás seguro de los datos ingresados?");
    
        if (confirmacion) {
            const parametrosURL = new URLSearchParams();
            parametrosURL.append("op", "registrarPersonas");
            parametrosURL.append("apellidos", apellido);
            parametrosURL.append("nombre", nombre);
            parametrosURL.append("idTipoDocumento", tipoDocumento);
            parametrosURL.append("documento", documento);
            parametrosURL.append("fechaNacimiento", fechaNacimiento);
            parametrosURL.append("telefono", telefono);
    
            fetch('../controllers/persona.php', {
                    method: 'POST',
                    body: parametrosURL
                })
                .then(respuesta => {
                    if (respuesta.ok) {
                        console.log('Persona registrada correctamente');
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    listar();

    const btnRegistrar = document.querySelector("#registrar-datos");
    btnRegistrar.addEventListener("click", registrar);

  });