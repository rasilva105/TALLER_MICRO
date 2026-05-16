'use strict';

window.view_list = async function(main) {
  const res  = await fetch(`${API}/clientes`);
  const data = await res.json();

  main.innerHTML = `
    <h1 class="page-title">👤 Clientes</h1>
    <div id="alert-zone"></div>
    <div class="card">
      <table>
        <thead><tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Licencia</th><th></th></tr></thead>
        <tbody>
          ${data.map(c => `
            <tr>
              <td>${c.id}</td>
              <td>${c.nombre}</td>
              <td>${c.telefono}</td>
              <td>${c.correo}</td>
              <td>${c.numero_licencia}</td>
              <td><button class="btn btn--danger btn--sm" data-del="${c.id}">Eliminar</button></td>
            </tr>`).join('')}
        </tbody>
      </table>
    </div>`;

  main.querySelectorAll('[data-del]').forEach(btn => {
    btn.addEventListener('click', async () => {
      if (!confirm('¿Eliminar cliente?')) return;
      await fetch(`${API}/clientes/${btn.dataset.del}`, {method:'DELETE'});
      window.view_list(main);
    });
  });
};

window.view_create = function(main) {
  main.innerHTML = `
    <h1 class="page-title">➕ Nuevo Cliente</h1>
    <div id="alert-zone"></div>
    <div class="card">
      <div class="form-grid">
        <div class="form-group"><label>Nombre</label><input id="nombre" placeholder="Carlos Mendoza"></div>
        <div class="form-group"><label>Teléfono</label><input id="telefono" placeholder="310-555-0101"></div>
        <div class="form-group"><label>Correo</label><input id="correo" type="email" placeholder="correo@ejemplo.com"></div>
        <div class="form-group"><label>Nº Licencia</label><input id="licencia" placeholder="LIC-001"></div>
      </div>
      <button class="btn btn--primary" id="btn-save">Guardar cliente</button>
    </div>`;

  $('#btn-save').addEventListener('click', async () => {
    const body = {
      nombre: $('#nombre').value, telefono: $('#telefono').value,
      correo: $('#correo').value, numero_licencia: $('#licencia').value,
    };
    const res  = await fetch(`${API}/clientes`, {
      method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(body)
    });
    const data = await res.json();
    res.ok ? showAlert($('#alert-zone'), `Cliente "${data.nombre}" creado`)
           : showAlert($('#alert-zone'), data.error, 'error');
  });
};
