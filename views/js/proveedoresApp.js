var url="http://localhost/PROYECTO/";
var idActualizar2;
var razonSocialActualizar2;
var direccionActualizar2;
var telefonoActualizar2;


document.getElementById("agregarProveedor").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    var razon = document.getElementById("razonAgregar");
    var direccion = document.getElementById("direccionAgregar");
    var telefono = document.getElementById("telefonoAgregar");
    const regexDireccion = /^[a-zA-Z0-9\s.,#-]+$/;
    const regexTelefono = /^(?:\+?502|00502)?[1-9]\d{7}$/;

    if(razon.value.length<1){
        mensajes.push('Agregue una razon o verifique su estructura ❌');
        resultado = false;
    }else{
        mensajes.push('Buena estructura de la razón ✔️');
    }
    if(regexDireccion.test(direccion.value)){
        mensajes.push('Buena estructura de la dirección ✔️');
    }else{
        mensajes.push('Agregue una dirección o verifique su estructura ❌');
        resultado = false;
    }

    if(regexTelefono.test(telefono.value)){
        mensajes.push('Buena estructura del telefono ✔️');
    }else{
        mensajes.push('Agregue un telefono o verifique su estructura ❌');
        resultado = false;
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



function enviarFormulario() {
    const formulario = document.getElementById("agregarProveedor");
    const formData = new FormData(formulario);
  
    fetch(url+"Proveedores/Crear", {
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
      if(data.Respuesta) AgregarFila(data.Valor.id, data.Valor.razonSocial, data.Valor.direccion, data.Valor.telefono);
    })
    .catch(error => {
      console.error("Error al enviar el formulario:", error);
      alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
    });
}

function AgregarFila(id, razonSocial, direccion, telefono){
    var nuevoTr = document.createElement('tr');
    nuevoTr.setAttribute('model-target', id);
    var nuevaCeldaRazonSocial = document.createElement('td');
    nuevaCeldaRazonSocial.textContent = razonSocial;

    var nuevaCeldaDireccion = document.createElement('td');
    nuevaCeldaDireccion.textContent = direccion;

    var nuevaCeldaTelefono = document.createElement('td');
    nuevaCeldaTelefono.textContent = telefono;

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
        Actualizar(id, razonSocial, direccion, telefono);
    };

    var td = document.createElement("td");
    td.appendChild(boton);
    td.appendChild(boton2);

    nuevoTr.appendChild(nuevaCeldaRazonSocial);
    nuevoTr.appendChild(nuevaCeldaDireccion);
    nuevoTr.appendChild(nuevaCeldaTelefono);
    nuevoTr.appendChild(td);

    var cuerpoTabla = document.getElementById("CuerpoTabla")
    cuerpoTabla.appendChild(nuevoTr);
}

function mostrarNotificacion(titulo, cuerpo, icono, boton){
    Swal.fire({
        title: titulo,
        html: cuerpo,
        icon: icono,
        confirmButtonText: boton
    });
}

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
            fetch(url+"Proveedores/Eliminar", {
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



function Actualizar(id, razonSocial, direccion, telefono){
    idActualizar2 = id;
    razonSocialActualizar2 = razonSocial;
    direccionActualizar2 = direccion;
    telefonoActualizar2 = telefono;
}

function LimpiarAgregar(){
    document.getElementById("razonAgregar").value = "";
    document.getElementById("direccionAgregar").value = "";
    document.getElementById("telefonoAgregar").value = "";
}

document.getElementById("eliminarProveedor").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    var razonEliminar = document.getElementById("razonEliminar");
    
if(razonEliminar.value.length<1){
    mensajes.push('Agregue una razon o verifique su estructura ❌');
    resultado = false;
}else{
    mensajes.push('Buena estructura de la razón ✔️');
}
    // Crear una lista de mensajes
    var listaMensajes = '<ul style="text-align: left;">'; 
    mensajes.forEach(function(mensaje) {
        listaMensajes += '<li>' + mensaje + '</li>';
    });
    listaMensajes += '</ul>';
    
    Swal.fire({
        title: 'Validación de Datos',
        html: listaMensajes,
        icon: resultado ? 'success' : 'error',
        confirmButtonText: 'Ok'
    });
});

function LimpiarEliminar(){
    document.getElementById("razonEliminar").value = "";
}

document.getElementById("actualizarProveedor").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    var razonActualizar = document.getElementById("razonActualizar");
    var direccionActualizar = document.getElementById("direccionActualizar");
    var telefonoActualizar = document.getElementById("telefonoActualizar");
    const regexDireccion = /^[a-zA-Z0-9\s.,#-]+$/;
    const regexTelefono = /^(?:\+?502|00502)?[1-9]\d{7}$/;

if(razonActualizar.value.length<1){
    mensajes.push('Agregue una razon o verifique su estructura ❌');
    resultado = false;
}else{
    mensajes.push('Buena estructura de la razón ✔️');
}
if(regexDireccion.test(direccionActualizar.value)){
    mensajes.push('Buena estructura de la dirección ✔️');
}else{
    mensajes.push('Agregue una dirección o verifique su estructura ❌');
    resultado = false;
}

if(regexTelefono.test(telefonoActualizar.value)){
    mensajes.push('Buena estructura del telefono ✔️');
}else{
    mensajes.push('Agregue un telefono o verifique su estructura ❌');
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
        actualizarProveedor(idActualizar2, razonActualizar.value, direccionActualizar.value, telefonoActualizar.value)
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

function actualizarProveedor(id, razonSocial, direccion, telefono){
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
            formulario.append('id', id);
            formulario.append('razonSocial', razonSocial);
            formulario.append('direccion', direccion);
            formulario.append('telefono', telefono);
            fetch(url+"Proveedores/Actualizar", {
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
                if(data.Respuesta) actualizarFila(id, razonSocial, direccion, telefono);
            })
            .catch(error => {
                console.error( error);
                alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
            });
        }
    });
}

function actualizarFila(id, razonSocial, direccion, telefono){
    var fila = document.querySelector('tr[model-target="'+id+'"]');
    fila.cells[0].textContent = razonSocial;
    fila.cells[1].textContent = direccion;
    fila.cells[2].textContent = telefono;
    var boton = fila.querySelector('button[data-toggle]');
    if (boton) {
        boton.onclick = function() {
            Actualizar(id, razonSocial, direccion, telefono); 
        };
    }
    
}


function LimpiarActualizar(){
    document.getElementById("razonActualizar").value = "";
    document.getElementById("direccionActualizar").value = "";
    document.getElementById("telefonoActualizar").value = "";
}