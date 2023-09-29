var url="http://localhost/PROYECTO/";
var idActualizar1;
var nombreActualizar1;
var apellidoActualizar1;
var sexoActualizar1;
var nitActualizar1;
var direccionActualizar1;
var telefonoActualizar1;
var emailActualizar1;


document.getElementById("agregarCliente").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var nombreCliente = document.getElementById("nombreCrear");
    var apellidoCliente = document.getElementById("apellidoCrear");
    var generoCliente = document.getElementById("generoCrear");
    var nitCliente = document.getElementById("nitCrear");
    var direccionCliente = document.getElementById("direccionCrear");
    var telefonoCliente = document.getElementById("telefonoCrear");
    var emailCliente = document.getElementById("emailCrear");
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    //Expresiones regulares para verificar el conseama de clientes
    //Esto estandarisa las entradas
    const regexDireccion = /^[a-zA-Z0-9\s.,#-]+$/;
    const regexNit = /^\d{1,}-?\d{1,}$/;
    const regexTelefono = /^(?:\+?502|00502)?[1-9]\d{7}$/;
    const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const regexNombre = /^[a-zA-Z]+$/;

    if(regexNombre.test(nombreCliente.value)){
        mensajes.push('Buena estructura del nombre ✔️');
    } else {
        mensajes.push('Agregue un nombre o verifique su estructura ❌');
        resultado = false;
    }
    if(regexNombre.test(apellidoCliente.value)){
        mensajes.push('Buena estructura del apellido ✔️');
    }else{
        mensajes.push('Agregue un apellido o verifique su estructura ❌');
        resultado = false;
    }
    if(generoCliente.value.length>0){
        mensajes.push('Genero seleccionado ✔️');
    }else{
        mensajes.push('Seleccione un genero ❌');
        resultado = false;
    }
    if(regexNit.test(nitCliente.value)){
        mensajes.push('Buena estructura del NIT ✔️');
    }else{
        mensajes.push('Agregue un NIT o verifique su estructura ❌');
        resultado = false;
    }
    if(regexDireccion.test(direccionCliente.value)){    
        mensajes.push('Buena estructura de la dirección ✔️');
    }else{
        mensajes.push('Agregue una dirección o verifique su estructura ❌');
        resultado = false;
    }
    if(regexTelefono.test(telefonoCliente.value)){
        mensajes.push('Buena estructura del teléfono ✔️');
    }else{
        mensajes.push('Agregue un teléfono o verifique su estructura ❌');
        resultado = false;
    }
    if(regexEmail.test(emailCliente.value)){
        mensajes.push('Buena estructura del email ✔️');
    }else{
        mensajes.push('Agregue un email o verifique su estructura ❌');
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
    Swal.fire({
        title: 'Validación de Datos',
        html: listaMensajes,
        icon: resultado ? 'success' : 'error',
        confirmButtonText: 'Ok'
    });
});

function enviarFormulario() {
    const formulario = document.getElementById("agregarCliente");
    const formData = new FormData(formulario);
  
    fetch(url+"Clientes/Crear", {
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
      if(data.Respuesta) AgregarFila(data.Valor.id, data.Valor.nombre, data.Valor.apellido, data.Valor.sexo, data.Valor.nit, data.Valor.direccion, data.Valor.telefono, data.Valor.email);
    })
    .catch(error => {
      console.error("Error al enviar el formulario:", error);
      alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
    });
}

function AgregarFila(id,nombre,apellido,sexo,nit,direccion,telefono,email){
    console.log(id);
    console.log(nombre);
    console.log(apellido);
    console.log(sexo);
    console.log(nit);
    var nuevoTr = document.createElement('tr');
    nuevoTr.setAttribute('model-target', id);
    var nuevaCeldaNombre = document.createElement('td');
    nuevaCeldaNombre.textContent = nombre;

    var nuevaCeldaApellido = document.createElement('td');
    nuevaCeldaApellido.textContent = apellido;

    var nuevaCeldaSexo = document.createElement('td');
    nuevaCeldaSexo.textContent = sexo;

    var nuevaCeldaNit = document.createElement('td');
    nuevaCeldaNit.textContent = nit;

    var nuevaCeldaDireccion = document.createElement('td');
    nuevaCeldaDireccion.textContent = direccion;

    var nuevaCeldaTelefono = document.createElement('td');
    nuevaCeldaTelefono.textContent = telefono;

    var nuevaCeldaEmail = document.createElement('td');
    nuevaCeldaEmail.textContent = email;

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
        Actualizar(id,nombre,apellido,sexo,nit,direccion,telefono,email);
    };

    var td = document.createElement("td");
    td.appendChild(boton);
    td.appendChild(boton2);

    nuevoTr.appendChild(nuevaCeldaNombre);
    nuevoTr.appendChild(nuevaCeldaApellido);
    nuevoTr.appendChild(nuevaCeldaSexo);
    nuevoTr.appendChild(nuevaCeldaNit);
    nuevoTr.appendChild(nuevaCeldaDireccion);
    nuevoTr.appendChild(nuevaCeldaTelefono);
    nuevoTr.appendChild(nuevaCeldaEmail);
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
        text: '¿Deseas eliminar este Cliente?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
            const formulario = new FormData();
            formulario.append('id', id);
            fetch(url+"Clientes/Eliminar", {
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

function LimpiarCrear()
{
    document.getElementById("nombreCrear").value = "";
    document.getElementById("apellidoCrear").value = "";
    document.getElementById("generoCrear").value = "";
    document.getElementById("nitCrear").value = "";
    document.getElementById("direccionCrear").value = "";
    document.getElementById("telefonoCrear").value = "";
    document.getElementById("emailCrear").value = "";
}

document.getElementById("eliminarCliente").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    var nombreClienteEliminar = document.getElementById("nombreClienteEliminar");
    const regexNombre = /^[a-zA-Z]+$/;


    if(regexNombre.test(nombreClienteEliminar.value)){
        mensajes.push('Buena estructura del nombre ✔️');
    }else{
        mensajes.push('Agregue un nombre o verifique su estructura ❌');
        resultado = false;
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

function LimpiarEliminar()
{
    document.getElementById("nombreClienteEliminar").value = "";
}

function Actualizar(id,nombre,apellido,sexo,nit,direccion,telefono,email){
    console.log(id);
    idActualizar1=id;
    nombreActualizar1=nombre;
    apellidoActualizar1=apellido;
    sexoActualizar1=sexo;
    nitActualizar1=nit;
    direccionActualizar1=direccion;
    telefonoActualizar1=telefono;
    emailActualizar1=email; 
}

document.getElementById("actualizarCliente").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var nombreActualizar = document.getElementById("nombreActualizar");
    var apellidoActualizar = document.getElementById("apellidoActualizar");
    var generoActualizar = document.getElementById("generoActualizar");
    var nitActualizar = document.getElementById("nitActualizar");
    var direccionActualizar = document.getElementById("direccionActualizar");
    var telefonoActualizar = document.getElementById("telefonoActualizar");
    var emailActualizar = document.getElementById("emailActualizar");
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    //Expresiones regulares para verificar el conseama de clientes
    //Esto estandarisa las entradas
    const regexDireccion = /^[a-zA-Z0-9\s.,#-]+$/;
    const regexNit = /^\d{1,}-?\d{1,}$/;
    const regexTelefono = /^(?:\+?502|00502)?[1-9]\d{7}$/;
    const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const regexNombre = /^[a-zA-Z]+$/;


    if(regexNombre.test(nombreActualizar.value)){
        mensajes.push('Buena estructura del nombre ✔️');
    } else {
        mensajes.push('Agregue un nombre o verifique su estructura ❌');
        resultado = false;
    }
    if(regexNombre.test(apellidoActualizar.value)){
        mensajes.push('Buena estructura del apellido ✔️');
    }else{
        mensajes.push('Agregue un apellido o verifique su estructura ❌');
        resultado = false;
    }
    if(generoActualizar.value.length>0){
        mensajes.push('Genero seleccionado ✔️');
    }else{
        mensajes.push('Seleccione un genero ❌');
        resultado = false;
    }
    if(regexNit.test(nitActualizar.value)){
        mensajes.push('Buena estructura del NIT ✔️');
    }else{
        mensajes.push('Agregue un NIT o verifique su estructura ❌');
        resultado = false;
    }
    if(regexDireccion.test(direccionActualizar.value)){    
        mensajes.push('Buena estructura de la dirección ✔️');
    }else{
        mensajes.push('Agregue una dirección o verifique su estructura ❌');
        resultado = false;
    }
    if(regexTelefono.test(telefonoActualizar.value)){
        mensajes.push('Buena estructura del teléfono ✔️');
    }else{
        mensajes.push('Agregue un teléfono o verifique su estructura ❌');
        resultado = false;
    }
    if(regexEmail.test(emailActualizar.value)){
        mensajes.push('Buena estructura del email ✔️');
    }else{
        mensajes.push('Agregue un email o verifique su estructura ❌');
        resultado = false;
    }
    // Crear una lista de mensajes
    var listaMensajes = '<ul style="text-align: left;">';
    mensajes.forEach(function(mensaje) {
        listaMensajes += '<li>' + mensaje + '</li>';
    });
    listaMensajes += '</ul>';
    
    if (resultado){
        actualizarCliente(idActualizar1, nombreActualizar.value, apellidoActualizar.value, generoActualizar.value, nitActualizar.value, direccionActualizar.value, telefonoActualizar.value, emailActualizar.value);
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

function actualizarCliente(id,nombre,apellido,sexo,nit,direccion,telefono,email){

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
            formulario.append('nombre',nombre);
            formulario.append('apellido',apellido);
            formulario.append('genero', sexo);
            formulario.append('nit', nit);
            formulario.append('direccion', direccion);
            formulario.append('telefono', telefono);
            formulario.append('email', email);
            fetch(url+"Clientes/Actualizar", {
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
                if(data.Respuesta) actualizarFila(id,nombre,apellido,sexo,nit,direccion,telefono,email);
            })
            .catch(error => {
                console.error( error);
                alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
            });
        }
    });
}
function actualizarFila(id, nombre, apellido, sexo, nit, direccion, telefono, email){
    var fila = document.querySelector('tr[model-target="'+id+'"]');
    fila.cells[0].textContent = nombre;
    fila.cells[1].textContent = apellido;
    fila.cells[2].textContent = sexo;
    fila.cells[3].textContent = nit;
    fila.cells[4].textContent = direccion;
    fila.cells[5].textContent = telefono;
    fila.cells[6].textContent = email;
    var boton = fila.querySelector('button[data-toggle]');
    if (boton) {
        boton.onclick = function() {
            Actualizar(id, nombre, apellido, sexo, nit, direccion, telefono, email); 
        };
    }
    
}

function LimpiarActualizar()
{
    document.getElementById("nombreActualizar").value = "";
    document.getElementById("apellidoActualizar").value = "";
    document.getElementById("generoActualizar").value = "";
    document.getElementById("nitActualizar").value = "";
    document.getElementById("direccionActualizar").value = "";
    document.getElementById("telefonoActualizar").value = "";
    document.getElementById("emailActualizar").value = "";
}