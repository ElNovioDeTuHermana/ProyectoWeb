var url="http://localhost/PROYECTO/";
var actulizarId;
var actualizarNombre;
var actualizarApellido;
var actualizarGenero;
var actualizarPuesto;
var actualizarUsuario;
var actualizarDireccion;
var actualizarTelefono;
var actualizarEmail;
var actualizarSueldo;
var actualizarRol;


document.getElementById("crearPersonal").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var nombre = document.getElementById("nombreAgregar");
    var apellido = document.getElementById("apellidoAgregar");
    var genero = document.getElementById("generoAgregar");
    var puesto = document.getElementById("puestoAgregar");
    var usuario = document.getElementById("usuarioAgregar");
    var direccion = document.getElementById("direccionAgregar");
    var telefono = document.getElementById("telefonoAgregar");
    var email = document.getElementById("emailAgregar");
    var sueldo = document.getElementById("sueldoAgregar");
    var contraseña = document.getElementById("contraseñaAgregar");
    
    var rol = document.getElementById("rolAgregar");
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    const regexDireccion = /^[a-zA-Z0-9\s.,#-]+$/;
    const regexTelefono = /^(?:\+?502|00502)?[1-9]\d{7}$/;
    const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const regexNombre = /^[a-zA-Z]+$/;
    const regexUsuario = /^[a-zA-Z0-9_-]{3,16}$/;
    /*Expresión regular para validar que la contraseña contenga al menos 1-letra 1-numero 1-caracter especial */
    const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
    const regexSueldo = /^(?:[^\d]*\d){3,}.*$/;

    if(regexNombre.test(nombre.value)){
        mensajes.push('Buena estructura del nombre ✔️');
    }else{
        mensajes.push('Agregue un nombre o verifique su estructura ❌');
        resultado = false;
    }
    if(regexNombre.test(apellido.value)){
        mensajes.push('Buena estructura del apellido ✔️');
    }else{
        mensajes.push('Agregue un apellido o verifique su estructura ❌');
        resultado = false;
    }
    if (genero.value === "") {
        mensajes.push('Seleccione un genero ❌');
        resultado = false;
    } else {
        mensajes.push('genero seleccionado ✔️');
    }
    if(puesto.value.length<1){
        mensajes.push('Agregue un puesto o verifique su estructura ❌');
        resultado = false;
    }else{
        mensajes.push('Buena estructura del puesto ✔️');
    }
    if(regexUsuario.test(usuario.value)){
        mensajes.push('Buena estructura del usuario ✔️');
    }else{
        mensajes.push('Agregue un usuario o verifique su estructura ❌');
        resultado = false;
    }
    if(regexPassword.test(contraseña.value)){
        mensajes.push('Buena estructura de la contraseña ✔️');
    }else{
        mensajes.push('Agregue una contrseña o verifique su estructura ❌');
        resultado = false;
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
    if(regexEmail.test(email.value)){
        mensajes.push('Buena estructura del email ✔️');
    }else{
        mensajes.push('Agregue un email o verifique su estructura ❌');
        resultado = false;
    }
    if(regexSueldo.test(sueldo.value)){
        mensajes.push('Buena estructura del sueldo ✔️');
    }else{
        mensajes.push('Agregue un sueldo o verifique su estructura ❌');
        resultado = false;
    }
    if (rol.value === "") {
        mensajes.push('Seleccione un rol ❌');
        resultado = false;
    } else {
        mensajes.push('rol seleccionado ✔️');
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






document.getElementById("actualizarPersonal").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener la recarga automática de la página
    var nombreActualizar = document.getElementById("nombreActualizar");
    var apellidoActualizar = document.getElementById("apellidoActualizar");
    var puestoActualizar = document.getElementById("puestoActualizar");
    var generoActualizar = document.getElementById("generoActualizar");
    var usuarioActualizar = document.getElementById("usuarioActualizar");
    var contraseñaActualizar = document.getElementById("contraseñaActualizar");
    var direccionActualizar = document.getElementById("direccionActualizar");
    var telefonoActualizar = document.getElementById("telefonoActualizar");
    var emailActualizar = document.getElementById("emailActualizar");
    var sueldoActualizar = document.getElementById("sueldoActualizar");
    var rolAgctualizar = document.getElementById("rolActualizar");
    var mensajes = []; // Usamos un array para almacenar los mensajes
    var resultado = true;
    const regexDireccion = /^[a-zA-Z0-9\s.,#-]+$/;
    const regexTelefono = /^(?:\+?502|00502)?[1-9]\d{7}$/;
    const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const regexNombre = /^[a-zA-Z]+$/;
    const regexUsuario = /^[a-zA-Z0-9_-]{3,16}$/;
    /*Expresión regular para validar que la contraseña contenga al menos 1-letra 1-numero 1-caracter especial */
    const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
    const regexSueldo = /^(?:[^\d]*\d){3,}.*$/;

    if(regexNombre.test(nombreActualizar.value)){
        mensajes.push('Buena estructura del nombre ✔️');
    }else{
        mensajes.push('Agregue un nombre o verifique su estructura ❌');
        resultado = false;
    }
    if(regexNombre.test(apellidoActualizar.value)){
        mensajes.push('Buena estructura del apellido ✔️');
    }else{
        mensajes.push('Agregue un apellido o verifique su estructura ❌');
        resultado = false;
    }
    if(puestoActualizar.value.length<1){
        mensajes.push('Agregue un puesto o verifique su estructura ❌');
        resultado = false;
    }else{
        mensajes.push('Buena estructura del puesto ✔️');
    }
    if(regexUsuario.test(usuarioActualizar.value)){
        mensajes.push('Buena estructura del usuario ✔️');
    }else{
        mensajes.push('Agregue un usuario o verifique su estructura ❌');
        resultado = false;
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
    if(regexEmail.test(emailActualizar.value)){
        mensajes.push('Buena estructura del email ✔️');
    }else{
        mensajes.push('Agregue un email o verifique su estructura ❌');
        resultado = false;
    }
    if(regexSueldo.test(sueldoActualizar.value)){
        mensajes.push('Buena estructura del sueldo ✔️');
    }else{
        mensajes.push('Agregue un sueldo o verifique su estructura ❌');
        resultado = false;
    }
    if (rolAgctualizar.value === "") {
        mensajes.push('Seleccione un rol ❌');
        resultado = false;
    } else {
        mensajes.push('rol seleccionado ✔️');
    }
    // Crear una lista de mensajes
    var listaMensajes = '<ul style="text-align: left;">'; 
    mensajes.forEach(function(mensaje) {
        listaMensajes += '<li>' + mensaje + '</li>';
    });
    listaMensajes += '</ul>';
    
    if(resultado){
        actualizarPersonal(actulizarId,
            nombreActualizar.value,
            apellidoActualizar.value,
            generoActualizar.value,
            puestoActualizar.value,
            usuarioActualizar.value,
            direccionActualizar.value,
            telefonoActualizar.value,
            emailActualizar.value,
            sueldoActualizar.value,
            rolAgctualizar.value);
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



//funciones *********************************

//funcion para enviar el formulario
function enviarFormulario() {
    const formulario = document.getElementById("crearPersonal");
    const formData = new FormData(formulario);
    
    console.log(formData.get("rol"));
    fetch(url+"Personal/Crear", {
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
      if(data.Respuesta) AgregarFila(data.Valor.id,data.Valor.nombre, data.Valor.apellido,data.Valor.sexo,
        data.Valor.puesto, data.Valor.usuario, data.Valor.direccion, data.Valor.telefono, 
        data.Valor.email, data.Valor.sueldo, data.Valor.rol
        );
    })
    .catch(error => {
      console.error("Error al enviar el formulario:", error);
      alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde." + error);
    });
}

//FUNCION MOSTRAR NOTIFICACION 

function mostrarNotificacion(titulo, cuerpo, icono, boton){
    Swal.fire({
        title: titulo,
        html: cuerpo,
        icon: icono,
        confirmButtonText: boton
    });
}

//FUNCION AGREGAR FILA 

function AgregarFila(id, nombre, apellido, genero, puesto, usuario, direccion, telefono,email, sueldo, rol ){
    var nuevoTr = document.createElement('tr');
    nuevoTr.setAttribute('model-target', id);

    var nuevaCeldaNombre = document.createElement('td');
    nuevaCeldaNombre.textContent = nombre;

    var nuevaCeldaApellido = document.createElement('td');
    nuevaCeldaApellido.textContent = apellido;

    var nuevaCeldaGenero = document.createElement('td');
    nuevaCeldaGenero.textContent = genero;

    var nuevaCeldaPuesto  = document.createElement('td');
    nuevaCeldaPuesto.textContent = puesto;

    var nuevaCeldaUsuario = document.createElement('td');
    nuevaCeldaUsuario.textContent = usuario;

    var nuevaCeldaDireccion = document.createElement('td');
    nuevaCeldaDireccion.textContent = direccion;

    var nuevaCeldaTelefono = document.createElement('td');
    nuevaCeldaTelefono.textContent = telefono;

    var nuevaCeldaEmail= document.createElement('td');
    nuevaCeldaEmail.textContent = email;

    var nuevaCeldaSueldo = document.createElement('td');
    nuevaCeldaSueldo.textContent = sueldo;

    var nuevaCeldaRol = document.createElement('td');
    var rolnombre;
    if(rol.id == 1) rolnombre = "Administrador";
    else if(rol.id == 2) rolnombre = "Vendedor";
    else if(rol.id == 3) rolnombre = "Bodeguero";
    nuevaCeldaRol.textContent = rolnombre;


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
        Actualizar(id, nombre, apellido, genero, puesto, usuario, direccion, telefono, email, sueldo, rol);
    };

    var td = document.createElement("td");
    td.appendChild(boton);
    td.appendChild(boton2);

    nuevoTr.appendChild(nuevaCeldaNombre);
    nuevoTr.appendChild(nuevaCeldaApellido);
    nuevoTr.appendChild(nuevaCeldaGenero);
    nuevoTr.appendChild(nuevaCeldaPuesto);
    nuevoTr.appendChild(nuevaCeldaUsuario);
    nuevoTr.appendChild(nuevaCeldaDireccion);
    nuevoTr.appendChild(nuevaCeldaTelefono);
    nuevoTr.appendChild(nuevaCeldaEmail);
    nuevoTr.appendChild(nuevaCeldaSueldo);
    nuevoTr.appendChild(nuevaCeldaRol);
    nuevoTr.appendChild(td);

    var cuerpoTabla = document.getElementById("CuerpoTabla")
    cuerpoTabla.appendChild(nuevoTr);
}

//FUNCION ACTUALIZAR 

function Actualizar(id, nombre, apellido, genero, puesto, usuario, direccion, telefono, email, sueldo, rol  ){
    actulizarId  = id;
    actualizarNombre = nombre;
    actualizarApellido = apellido;
    actualizarGenero = genero;
    actualizarPuesto = puesto;
    actualizarUsuario = usuario;
    actualizarDireccion = direccion;
    actualizarTelefono = telefono;
    actualizarEmail = email;
    actualizarSueldo = sueldo;
    actualizarRol = rol;
}

//FUNCION ELIMINAR 

function Eliminar(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas eliminar este personal?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            const formulario = new FormData();
            formulario.append('id', id);
            fetch(url+"Personal/Eliminar", {
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

//FUNCION ACTUALIZAR 

function actualizarPersonal(id, nombre, apellido, genero, puesto, usuario, direccion, telefono, email, sueldo, rol){
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
            formulario.append('nombre', nombre);
            formulario.append('apellido', apellido);
            formulario.append('genero', genero);
            formulario.append('puesto', puesto);
            formulario.append('usuario', usuario);
            formulario.append('direccion', direccion);
            formulario.append('telefono', telefono);
            formulario.append('email', email);
            formulario.append('sueldo', sueldo);
            formulario.append('rol', rol);
            fetch(url+"Personal/Actualizar", {
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
                if(data.Respuesta) actualizarFila(id, nombre, apellido, genero, puesto, usuario, direccion, telefono, email, sueldo, rol);
            })
            .catch(error => {
                console.error( error);
                alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
            });
        }
    });
}

function actualizarFila(id, nombre, apellido, genero, puesto, usuario, direccion, telefono, email, sueldo, rol){
    var fila = document.querySelector('tr[model-target="'+id+'"]');
    fila.cells[0].textContent = nombre;
    fila.cells[1].textContent = apellido;
    fila.cells[2].textContent = genero;
    fila.cells[3].textContent = puesto;
    fila.cells[4].textContent = usuario;
    fila.cells[5].textContent = direccion;
    fila.cells[6].textContent = telefono;
    fila.cells[7].textContent = email;
    fila.cells[8].textContent = sueldo;
    var nombreRol;
    if(rol == 1) nombreRol = "Administrador";
    else if(rol == 2) nombreRol = "Vendedor";
    else if(rol == 3) nombreRol = "Bodeguero";
    fila.cells[9].textContent = nombreRol;
    var boton = fila.querySelector('button[data-toggle]');
    if (boton) {
        boton.onclick = function() {
            Actualizar(id, nombre, apellido, genero, puesto, usuario, direccion, telefono, email, sueldo, rol); 
        };
    }
    
}


//FUNCION LIMPIAR
function LimpiarActualizar(){
    document.getElementById("nombreActualizar").value="";
    document.getElementById("apellidoActualizar").value="";
    document.getElementById("puestoActualizar").value="";
    document.getElementById("usuarioActualizar").value="";
    document.getElementById("direccionActualizar").value="";
    document.getElementById("telefonoActualizar").value="";
    document.getElementById("emailActualizar").value="";
    document.getElementById("sueldoActualizar").value="";
    document.getElementById("rolActualizar").value="";
}

function LimpiarCrear(){
    document.getElementById("nombreAgregar").value = "";
    document.getElementById("apellidoAgregar").value = "";
    document.getElementById("generoAgregar").value = "";
    document.getElementById("puestoAgregar").value = "";
    document.getElementById("usuarioAgregar").value = "";
    document.getElementById("contraseñaAgregar").value = "";
    document.getElementById("direccionAgregar").value = "";
    document.getElementById("telefonoAgregar").value = "";
    document.getElementById("emailAgregar").value = "";
    document.getElementById("sueldoAgregar").value = "";
    document.getElementById("rolAgregar").value = "";
}

function LimpiarEliminar(){
    document.getElementById("nombreEliminar").value = "";
}