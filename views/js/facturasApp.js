var url="http://localhost/PROYECTO/";
var ventaId;

document.getElementById("tablaVentas").addEventListener("click", function(event){
    const fila = event.target.closest("tr");
    if(fila){
      const id = fila.getAttribute("model-data");
      if(id){
        requestProductosIngreso(id);
      }
    }
})

function requestProductosIngreso(id){
    const formData = new FormData();
      formData.append("id", id);
    
      fetch(url+"Facturas/productosOfVentaById", {
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
        console.log(data.Valor);
        llenarTablaProductosVenta(data.Valor);
      })
      .catch(error => {
        alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
      });
  }


  function llenarTablaProductosVenta(productos){
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
      cell3.textContent = producto.stock;
      const cell4 = document.createElement("td");
      cell4.textContent = "Q"+producto.precioVenta;
    
      newRow.appendChild(cell1);
      newRow.appendChild(cell2);
      newRow.appendChild(cell3);
      newRow.appendChild(cell4);
    
      tbody.appendChild(newRow);
    });
    
  }