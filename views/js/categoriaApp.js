var categoriaId;
var nombreCategoria;
var url="http://localhost/PROYECTO/";

document.getElementById("crearCategoria").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var categoria = document.getElementById("nombreCategoria");
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    const regexNombre = /^[a-zA-Z]+$/;


    
    if(regexNombre.test(categoria.value)){
        mensajes.push('Buena estructura del nombre ✔️'); 
    } else {
        mensajes.push('Mala estructura del nombre ❌');
        resultado = false;
    }
    // Crear una lista de mensajes
    var listaMensajes = '<ul style="text-align: left;">';
    mensajes.forEach(function(mensaje) {
        listaMensajes += '<li>' + mensaje + '</li>';
    });
    listaMensajes += '</ul>';
    
    if(resultado)
    {
        enviarFormulario();
    }
    else{
        mostrarNotificacion('Validacion de Datos', listaMensajes, 'error',  'OK')
    }
});

function mostrarNotificacion(titulo, cuerpo, icono, boton){
    Swal.fire({
        title: titulo,
        html: cuerpo,
        icon: icono,
        confirmButtonText: boton
    });
}

function enviarFormulario() {
    const formulario = document.getElementById("crearCategoria");
    const formData = new FormData(formulario);
    const nombreCategoria = formData.get("nombreCategoria");
  
    fetch(url+"Categorias/Crear", {
      method: "POST",
      body: formData,
    })
    .then(response => {
      if (response.ok) { 
        return response.json();
      } else {
        throw new Error('Error en la respuesta del servidor: ${response.status} ${response.statusText}');
      }
    })
    .then(data => {
      console.log(data);
      mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error', 'OK');
      if(data.Respuesta) AgregarFila(data.Valor, nombreCategoria);
    })
    .catch(error => {
      console.error("Error al enviar el formulario:", error);
      alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
    });
  }

function LimpiarCrear()
{
    document.getElementById("nombreCategoria").value = "";
}

function Eliminar(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas eliminar esta categoría?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
            const formulario = new FormData();
            formulario.append('categoriaId', id);
            fetch(url+"Categorias/Eliminar", {
            method: "POST",
            body: formulario,
            })
            .then(response => {
            if (response.ok) { 
                return response.json();
            } else {
                throw new Error('Error en la respuesta del servidor: ${response.status} ${response.statusText}');
            }
            })
            .then(data => {
                console.log(data);
                mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error', 'OK');
                if(data.Respuesta) EliminarFila(id);
            })
            .catch(error => {
                console.error( error);
                alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
            });
        }
    });
}

function EliminarFila(id){
    var fila = document.querySelector('tr[model-target="'+id+'"]');
    
    fila.remove();
}

function AgregarFila(id, nombre){
    var nuevoTr = document.createElement('tr');
    nuevoTr.setAttribute('model-target', id);
    var nuevaCelda = document.createElement('td');
    nuevaCelda.textContent = nombre;

    var boton = document.createElement("button");
    boton.type = "button";
    boton.className = "btn btn-danger";
    boton.textContent = "Eliminar";
    boton.onclick = function() {
        Eliminar(id);
    };

    var boton2 = document.createElement("button");
    boton2.type = "button";
    boton2.className = "btn btn-primary";
    boton2.textContent = "Actualizar";
    boton2.setAttribute("data-toggle", "modal");
    boton2.setAttribute("data-target", "#ModalActualizar");
    boton2.onclick = function() {
        Actualizar(id, nombre);
    };

    var td = document.createElement("td");
    td.appendChild(boton);
    td.appendChild(boton2);

    nuevoTr.appendChild(nuevaCelda);
    nuevoTr.appendChild(td);

    var cuerpoTabla = document.getElementById("CuerpoTabla")
    cuerpoTabla.appendChild(nuevoTr);
}

function Actualizar(id, nombre){
    categoriaId = id;
    nombreCategoria = nombre;
    console.log(id);
    console.log(nombre);
}



document.getElementById("actualizarCategoria").addEventListener("submit", function(event) {
    event.preventDefault(); 
    var categoriaActualizar = document.getElementById("nombreCategoriaActualizar");
    var mensajes = []; 
    var resultado = true;
    const regexNombre = /^[a-zA-Z]+$/;

    if(regexNombre.test(categoriaActualizar.value)){
        mensajes.push('Buena estructura del nombre ✔️');
    } else {
        mensajes.push('Mala estructura del nombre ❌');
        resultado = false;
    }
    
    var listaMensajes = '<ul style="text-align: left;">';
    mensajes.forEach(function(mensaje) {
        listaMensajes += '<li>' + mensaje + '</li>';
    });
    listaMensajes += '</ul>';
    

    if(resultado){
        ActualizarCategoria(categoriaId, categoriaActualizar.value);
    }
    else{
        Swal.fire({
            title: 'Validación de Datos',
            html: listaMensajes,
            icon: resultado ? 'success' : 'error',
            confirmButtonText: 'Ok'
        });
    }
    
});

function ActualizarCategoria(id, nombre){
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas Actualizar esta categoría?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, Actualizar',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
            const formulario = new FormData();
            formulario.append('categoriaId', id);
            formulario.append('nombreCategoria', nombre)
            fetch(url+"/Categorias/Actualizar", {
            method: "POST",
            body: formulario,
            })
            .then(response => {
            if (response.ok) { 
                return response.json();
            } else {
                throw new Error('Error en la respuesta del servidor: ${response.status} ${response.statusText}');
            }
            })
            .then(data => {
                console.log(data);
                mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error', 'OK');
                if(data.Respuesta) actualizarFila(id, nombre);
            })
            .catch(error => {
                console.error( error);
                alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
            });
        }
    });
}

function actualizarFila(id, nombre){
    var fila = document.querySelector('tr[model-target="'+id+'"]');
    fila.cells[0].textContent = nombre;
    var boton = fila.querySelector('button[data-toggle]');
    if (boton) {
        boton.onclick = function() {
            Actualizar(id, nombre); 
        };
    }
    
}

function LimpiarActualizar()
{
    document.getElementById("nombreCategoriaActualizar").value = "";
}