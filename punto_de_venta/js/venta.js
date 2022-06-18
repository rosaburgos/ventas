let selectedProducts = [];
function addProduct(id) {
  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'http://localhost/punto_de_venta/index.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('id=' + id);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      response.cantidad = 1;
      let product = selectedProducts.findIndex(item => {
        return item.id == response.id;
      })
      if (product == -1) {
        selectedProducts.push(response);
      } else {
        selectedProducts[product].cantidad++;
      }
      fillTable();
    }
  }
}

function fillTable() {
  let tbody = document.getElementById('tbody');
  tbody.innerHTML = '';
  let template = '';
  selectedProducts.forEach(function (product) {
    template += `
      <tr>
        <td>${product.id}</td>
        <td>${product.nombre}</td>
        <td>${product.precio}</td>
        <td>${product.cantidad}</td>
        <td>${product.precio * product.cantidad}</td>
      </tr>`;
  }
  );
  tbody.innerHTML = template;
  llenarTablaIva();
  window.scrollTo(0, document.body.scrollHeight);
}

function llenarTablaIva() {
  let tbody2 = document.getElementById('tbody2');
  tbody2.innerHTML = '';
  let base = selectedProducts.reduce(function (total, product) {
    return total + (product.precio * product.cantidad);
  }, 0);

  let iva = base * 0.19;

  let total = base + iva;
  let template =
    ` <tr>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right">Base</td>
        <td id="base">${base}</td>
      </tr>
      <tr>
      <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right">IVA</td>
        <td id="iva">${iva}</td>
      </tr>
      <tr>
      <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right">Total</td>
        <td id="total">${total}</td>
      </tr>`

  tbody2.innerHTML = template;
}

function comprar() {
  xhr = new XMLHttpRequest();
  xhr.open('POST', 'http://localhost/punto_de_venta/venta.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('selectedProducts=' + JSON.stringify(selectedProducts));
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log(xhr.responseText);
      alert('Venta realizada');
      window.location.href = 'http://localhost/punto_de_venta/index.php';
    }
  }
}