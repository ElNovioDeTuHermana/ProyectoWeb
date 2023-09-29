var url="http://localhost/PROYECTO/";
var idActualizar;
var codigoActualizar;
var nombreActualizar;
var descripcionActualizar;

document.getElementById("crearProducto").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var codigo = document.getElementById("codigoCrear");
    var nombre = document.getElementById("nombreCrear");
    var descripcion = document.getElementById("descripcionCrear");
    var proveedor =document.getElementById("proveedoresSelect");

    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    const regexNombre = /^[A-Za-z0-9\s\-,.&()']+$/;


    if (codigo.value.length < 3) {
        mensajes.push('Ingrese un código válido o código muy corto ❌');
        resultado = false;
    } else {
        mensajes.push('Estructura del código válida ✔️');
    }
    if(regexNombre.test(nombre.value)){
        mensajes.push('Buena estructura del nombre ✔️');
    } else {
        mensajes.push('Mala estructura del nombre ❌');
        resultado = false;
    }
    if(descripcion.value < 1){
        mensajes.push('Ingrese una descripción o descripción muy corta ❌');
        resultado = false;
    } else {
        mensajes.push('Estructura de descripción válida ✔️');
    }
    if(proveedor.value === " "){

        mensajes.push('Seleccione un proveedor ❌');
        resultado = false;
    } else {
        mensajes.push('proveedor seleccionado ✔️');
    }
    // Crear una lista de mensajes
    var listaMensajes = '<ul style="text-align: left;">';
    mensajes.forEach(function(mensaje) {
        listaMensajes += '<li>' + mensaje + '</li>';
    });
    listaMensajes += '</ul>';

    if(resultado){
        enviarFormulario();
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


document.getElementById("actualizarProducto").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var codigo = document.getElementById("codigoActualizar");
    var nombre = document.getElementById("nombreActualizar");
    var descripcion = document.getElementById("descripcionActualizar");
    var imagen = document.getElementById("imagenActualizar");
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    const regexNombre = /^[A-Za-z0-9\s\-,.&()']+$/;

    if (codigo.value.length < 3) {
        mensajes.push('Ingrese un código válido o código muy corto ❌');
        resultado = false;
    } else {
        mensajes.push('Estructura del código válida ✔️');
    }
    if(regexNombre.test(nombre.value)){
        mensajes.push('Buena estructura del nombre ✔️');
    } else {
        mensajes.push('Mala estructura del nombre ❌');
        resultado = false;
    }
    if(descripcion.value < 1){
        mensajes.push('Ingrese una descripción o descripción muy corta ❌');
        resultado = false;
    } else {
        mensajes.push('Estructura de descripción válida ✔️');
    }
    // Crear una lista de mensajes
    var listaMensajes = '<ul style="text-align: left;">';
    mensajes.forEach(function(mensaje) {
        listaMensajes += '<li>' + mensaje + '</li>';
    });
    listaMensajes += '</ul>';
    
    if (resultado){

        actualizarProducto(idActualizar, codigo.value, nombre.value, descripcion.value);
    }else {
        Swal.fire({
            title: 'Validación de Datos',
            html: listaMensajes,
            icon: resultado ? 'success' : 'error',
            confirmButtonText: 'Ok'
        });
    }
});


//funciones *********************************

//funcion para enviar el formulario
function enviarFormulario() {
    const formulario = document.getElementById("crearProducto");
    const formData = new FormData(formulario);
  
    fetch(url+"Productos/Crear", {
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
      if(data.Respuesta) AgregarFila(data.Valor.id,data.Valor.codigo, data.Valor.nombre, data.Valor.descripcion);
    })
    .catch(error => {
      console.error("Error al enviar el formulario:", error);
      alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
    });
}

function mostrarNotificacion(titulo, cuerpo, icono, boton){
    Swal.fire({
        title: titulo,
        html: cuerpo,
        icon: icono,
        confirmButtonText: boton
    });
}


function AgregarFila(id, codigo, nombre, descripcion){
    var nuevoTr = document.createElement('tr');
    nuevoTr.setAttribute('model-target', id);

    var nuevaCeldaCodigo = document.createElement('td');
    nuevaCeldaCodigo.textContent = codigo;

    var nuevaCeldaNombre = document.createElement('td');
    nuevaCeldaNombre.textContent = nombre;

    var nuevaCeldaDescripcion = document.createElement('td');
    nuevaCeldaDescripcion.textContent = descripcion;

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
        Actualizar(id, codigo, nombre, descripcion);
    };

    var td = document.createElement("td");
    td.appendChild(boton);
    td.appendChild(boton2);

    nuevoTr.appendChild(nuevaCeldaCodigo);
    nuevoTr.appendChild(nuevaCeldaNombre);
    nuevoTr.appendChild(nuevaCeldaDescripcion);
    nuevoTr.appendChild(td);

    var cuerpoTabla = document.getElementById("CuerpoTabla")
    cuerpoTabla.appendChild(nuevoTr);
}


function Actualizar(id, codigo, nombre, descripcion){
    idActualizar = id;
    codigoActualizar = codigo;
    nombreActualizar = nombre;
    descripcionActualizar = descripcion;
}


//FUNCION PARA ELIMARN

function Eliminar(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas eliminar este Proveedor?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
            const formulario = new FormData();
            formulario.append('id', id);
            fetch(url+"Productos/Eliminar", {
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



function actualizarProducto(id, codigo, nombre, descripcion){
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas Actualizar este Personal?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, Actualizar',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
            const formulario = new FormData();
            formulario.append('id', id);
            formulario.append('codigo', codigo);
            formulario.append('nombre', nombre);
            formulario.append('descripcion', descripcion);
            fetch(url+"Productos/Actualizar", {
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
                if(data.Respuesta) actualizarFila(id, codigo, nombre, descripcion);
            })
            .catch(error => {
                console.error( error);
                alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
            });
        }
    });
}

function actualizarFila(id, codigo, nombre, descripcion){
    var fila = document.querySelector('tr[model-target="'+id+'"]');
    fila.cells[0].textContent = codigo;
    fila.cells[1].textContent = nombre;
    fila.cells[2].textContent = descripcion;
    var nombreRol;

    var boton = fila.querySelector('button[data-toggle]');
    if (boton) {
        boton.onclick = function() {
            Actualizar(id, codigo, nombre, descripcion); 
        };
    }
    
}



function LimpiarActualizar()
{
    document.getElementById("codigoActualizar").value = "";
    document.getElementById("nombreActualizar").value ="";
    document.getElementById("descripcionActualizar").value ="";
}

function LimpiarCrear()
{
    document.getElementById("codigoCrear").value = "";
    document.getElementById("nombreCrear").value ="";
    document.getElementById("descripcionCrear").value ="";
}

function LimpiarEliminar()
{
    document.getElementById("nombreEliminar").value ="";
}