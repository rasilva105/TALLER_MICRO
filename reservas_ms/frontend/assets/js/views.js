'use strict';

window.view_list = async function(main) {
  const res  = await fetch(`${API}/reservas`);
  const data = await res.json();

  main.innerHTML = `
    <h1 class="page-title">📋 Reservas</h1>
    <div id="alert-zone"></div>
    <div class="card">
      <table>
        <thead><tr><th>ID</th><th>Cliente</th><th>Vehículo</th><th>Inicio</th><th>Fin</th><th>Estado</th><th>Acciones</th></tr></thead>
        <tbody>
          ${data.map(r => `
            <tr>
              <td>${r.id}</td>
              <td>#${r.cliente_id}</td>
              <td>#${r.vehiculo_id}</td>
              <td>${r.fecha_inicio}</td>
              <td>${r.fecha_fin}</td>
              <td>${badgeEstado(r.estado)}</td>
              <td>
                ${r.estado === 'activa' ? `
                  <button class="btn btn--sm" style="background:#dcfce7;color:#15803d" data-completar="${r.id}">✓ Completar</button>
                  <button class="btn btn--danger btn--sm" data-cancelar="${r.id}">✗ Cancelar</button>
                ` : '—'}
              </td>
            </tr>`).join('')}
        </tbody>
      </table>
    </div>`;

  const cambiarEstado = async (id, estado) => {
    await fetch(`${API}/reservas/${id}/estado`, {
      method:'PATCH', headers:{'Content-Type':'application/json'},
      body: JSON.stringify({estado})
    });
    window.view_list(main);
  };

  main.querySelectorAll('[data-completar]').forEach(b => b.addEventListener('click', () => cambiarEstado(b.dataset.completar, 'completada')));
  main.querySelectorAll('[data-cancelar]').forEach(b  => b.addEventListener('click', () => cambiarEstado(b.dataset.cancelar,  'cancelada')));
};

window.view_create = function(main) {
  main.innerHTML = `
    <h1 class="page-title">➕ Nueva Reserva</h1>
    <div id="alert-zone"></div>
    <div class="card">
      <div class="form-grid">
        <div class="form-group"><label>ID Cliente</label><input id="cliente_id" type="number" placeholder="1"></div>
        <div class="form-group"><label>ID Vehículo</label><input id="vehiculo_id" type="number" placeholder="1"></div>
        <div class="form-group"><label>Fecha inicio</label><input id="fecha_inicio" type="date"></div>
        <div class="form-group"><label>Fecha fin</label><input id="fecha_fin" type="date"></div>
      </div>
      <button class="btn btn--primary" id="btn-save">Crear reserva</button>
    </div>`;

  $('#btn-save').addEventListener('click', async () => {
    const body = {
      cliente_id:   parseInt($('#cliente_id').value),
      vehiculo_id:  parseInt($('#vehiculo_id').value),
      fecha_inicio: $('#fecha_inicio').value,
      fecha_fin:    $('#fecha_fin').value,
    };
    const res  = await fetch(`${API}/reservas`, {
      method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(body)
    });
    const data = await res.json();
    res.ok ? showAlert($('#alert-zone'), `Reserva #${data.id} creada`)
           : showAlert($('#alert-zone'), data.error, 'error');
  });
};
