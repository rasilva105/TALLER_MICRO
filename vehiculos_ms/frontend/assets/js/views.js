'use strict';

// ── Vista: Listado de vehículos ──
window.view_list = async function(main) {
  const res  = await fetch(`${API}/vehiculos`);
  const data = await res.json();

  main.innerHTML = `
    <h1 class="page-title">🚗 Vehículos</h1>
    <div id="alert-zone"></div>
    <div class="card">
      <table>
        <thead>
          <tr><th>ID</th><th>Marca</th><th>Modelo</th><th>Año</th><th>Categoría</th><th>Estado</th><th>Acciones</th></tr>
        </thead>
        <tbody>
          ${data.map(v => `
            <tr>
              <td>${v.id}</td>
              <td>${v.marca}</td>
              <td>${v.modelo}</td>
              <td>${v.anio}</td>
              <td>${v.categoria}</td>
              <td>${badgeEstado(v.estado)}</td>
              <td>
                <select data-id="${v.id}" class="estado-sel" style="font-size:.75rem;padding:.2rem .4rem;border-radius:6px;border:1px solid var(--border)">
                  <option value="">Cambiar estado</option>
                  <option value="disponible">disponible</option>
                  <option value="alquilado">alquilado</option>
                  <option value="mantenimiento">mantenimiento</option>
                </select>
                <button class="btn btn--danger btn--sm" data-del="${v.id}" style="margin-left:.35rem">Eliminar</button>
              </td>
            </tr>`).join('')}
        </tbody>
      </table>
    </div>`;

  // Cambiar estado
  main.querySelectorAll('.estado-sel').forEach(sel => {
    sel.addEventListener('change', async () => {
      if (!sel.value) return;
      await fetch(`${API}/vehiculos/${sel.dataset.id}/estado`, {
        method: 'PATCH',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({estado: sel.value})
      });
      showAlert($('#alert-zone'), 'Estado actualizado');
      window.view_list(main);
    });
  });

  // Eliminar
  main.querySelectorAll('[data-del]').forEach(btn => {
    btn.addEventListener('click', async () => {
      if (!confirm('¿Eliminar vehículo?')) return;
      await fetch(`${API}/vehiculos/${btn.dataset.del}`, {method:'DELETE'});
      window.view_list(main);
    });
  });
};

// ── Vista: Crear vehículo ──
window.view_create = function(main) {
  main.innerHTML = `
    <h1 class="page-title">➕ Nuevo Vehículo</h1>
    <div id="alert-zone"></div>
    <div class="card">
      <div class="form-grid">
        <div class="form-group"><label>Marca</label><input id="marca" placeholder="Toyota"></div>
        <div class="form-group"><label>Modelo</label><input id="modelo" placeholder="Corolla"></div>
        <div class="form-group"><label>Año</label><input id="anio" type="number" placeholder="2024"></div>
        <div class="form-group"><label>Categoría</label>
          <select id="categoria">
            <option value="Sedan">Sedán</option>
            <option value="SUV">SUV</option>
            <option value="Compacto">Compacto</option>
            <option value="Pickup">Pickup</option>
          </select>
        </div>
      </div>
      <button class="btn btn--primary" id="btn-save">Guardar vehículo</button>
    </div>`;

  $('#btn-save').addEventListener('click', async () => {
    const body = {
      marca: $('#marca').value, modelo: $('#modelo').value,
      anio: parseInt($('#anio').value), categoria: $('#categoria').value,
    };
    const res = await fetch(`${API}/vehiculos`, {
      method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify(body)
    });
    const data = await res.json();
    if (res.ok) showAlert($('#alert-zone'), `Vehículo "${data.marca} ${data.modelo}" creado`);
    else showAlert($('#alert-zone'), data.error, 'error');
  });
};
