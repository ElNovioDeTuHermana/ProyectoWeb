var url="http://localhost/PROYECTO/";

document.getElementById("btnBuscar").addEventListener("click", function(){
    var valorBusqueda = document.getElementById("inputBuscar").value;
    requestProductos(valorBusqueda);
})

document.getElementById("btnFinalizar").addEventListener("click", function(){
    
})

document.getElementById("datosCliente").addEventListener("submit", function(event){
  event.preventDefault();
  var datosCliente = obtenerDatosCliente();
  var datos = obtenerDatos();
  console.log(datosCliente);
  enviarVenta(datos, datosCliente[0], datosCliente[1])
})

function obtenerDatosCliente(){
  var nombre = document.getElementById("clienteNombre").value;
  var nit = document.getElementById("clienteNit").value;
  if(nombre.length <= 0) nombre = "Consumidor Final";
  if(nit.length <= 0) nit = "C/F";
  return [nombreCliente = nombre,
          nitCliente = nit]
}

function enviarVenta(stocks, nombre, nit){
  const formData = new FormData();
  stocksJSON = JSON.stringify(stocks);
    formData.append("stocks", stocksJSON);
    formData.append("nombre", nombre);
    formData.append("nit", nit);
  
    fetch(url+"Venta/Crear", {
      method: "POST",
      body: formData,
    })
    .then(response => {
      if (response.ok) { 
        return response.json();
      } else {
        throw new Error('${response.status} ${response.statusText}');
      }
    })
    .then(data => {
      //console.log(data.Valor);
      mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error', 'OK')
    })
    .catch(error => {
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

function requestProductos(valorBusqueda){
    const formData = new FormData();
    formData.append("busqueda", valorBusqueda);
  
    fetch(url+"Venta/busqueda", {
      method: "POST",
      body: formData,
    })
    .then(response => {
      if (response.ok) { 
        return response.json();
      } else {
        throw new Error('${response.status} ${response.statusText}');
      }
    })
    .then(data => {
      //console.log(data.Valor);
      llenarTablaBusqueda(data.Valor);
    })
    .catch(error => {
      alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
    });
}

function llenarTablaBusqueda(productos){
    const tbody = document.getElementById("bodyTablaProductos");
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    productos.forEach(function(producto){

    const newRow = document.createElement("tr");

    const cell1 = document.createElement("td");
    cell1.textContent = producto.producto.codigo;
    const cell2 = document.createElement("td");
    cell2.textContent = producto.producto.nombre;
    const cell3 = document.createElement("td");
    cell3.textContent = "Q"+producto.precioVenta;
    const cell4 = document.createElement("td");
    cell4.textContent = producto.stock;

    const cell5 = document.createElement("td");
    const boton = document.createElement("button");
    boton.setAttribute("type", "button");
    boton.className = "btn btn-primary";
    boton.textContent = "Agregar";
    boton.addEventListener("click", function() {
        llenarTablaProductosVenta(producto.producto.codigo, 
                                producto.producto.nombre, 
                                producto.precioVenta,
                                producto.id,
                                producto.producto.id);
    });
    cell5.appendChild(boton);
  
    newRow.appendChild(cell1);
    newRow.appendChild(cell2);
    newRow.appendChild(cell3);
    newRow.appendChild(cell4);
    newRow.appendChild(cell5);
  
    tbody.appendChild(newRow);
    });
}

function llenarTablaProductosVenta(codigo, nombre, precio, stockId, productoId){
    const tbody = document.getElementById("bodyProductosVenta");

    const newRow = document.createElement("tr");
    newRow.setAttribute("data-model", stockId);

    const cell1 = document.createElement("td");
    const input = document.createElement("input");
    input.type = "text"; 
    cell1.appendChild(input);

    const cell2 = document.createElement("td");
    cell2.textContent = codigo;
    const cell3 = document.createElement("td");
    cell3.textContent = nombre;
    const cell4 = document.createElement("td");
    cell4.setAttribute("precioVenta", precio);
    cell4.textContent = "Q"+precio;

    const cell5 = document.createElement("td");
    const boton = document.createElement("button");
    boton.setAttribute("type", "button");
    boton.className = "btn btn-danger";
    boton.textContent = "Eliminar";
    boton.addEventListener("click", function() {
        const fila = tbody.querySelector(`tbody tr[data-model="${stockId}"]`);
        fila.remove();
    });
    cell5.appendChild(boton);
  
    newRow.appendChild(cell1);
    newRow.appendChild(cell2);
    newRow.appendChild(cell3);
    newRow.appendChild(cell4);
    newRow.appendChild(cell5);
  
    tbody.appendChild(newRow);
    
}

function obtenerDatos(){
    const tbody = document.getElementById("bodyProductosVenta");
    const filas = tbody.getElementsByTagName("tr");
    var stocks = new Array();

    for (let i = 0; i < filas.length; i++) {
        var stock = {
            id:0,
            cantidad: 0,
            precioVenta: 0
        }
        const dataModel = filas[i].getAttribute("data-model");
        stock.id = dataModel;
        
        const inputs = filas[i].getElementsByTagName("input");
        stock.cantidad = inputs[0].value;

        stock.precioVenta = filas[i].querySelectorAll('td')[3].getAttribute("precioVenta");
        
        
        stocks.push(stock);
    }

    return stocks;
    
}

