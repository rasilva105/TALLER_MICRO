'use strict';
const API = 'http://localhost:8002';

const $ = (sel) => document.querySelector(sel);
const $$ = (sel) => document.querySelectorAll(sel);

// Navegación SPA simple
document.addEventListener('DOMContentLoaded', () => {
  $$('.l-nav__link[data-view]').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const view = link.dataset.view;
      $$('.l-nav__link').forEach(l => l.classList.remove('active'));
      link.classList.add('active');
      loadView(view);
    });
  });
  // Cargar vista inicial
  const first = $('.l-nav__link[data-view]');
  if (first) { first.classList.add('active'); loadView(first.dataset.view); }
});

function loadView(view) {
  const main = $('#main-content');
  main.innerHTML = '<p style="color:var(--muted);font-size:.875rem">Cargando...</p>';
  if (typeof window['view_' + view] === 'function') {
    window['view_' + view](main);
  }
}

function showAlert(parent, msg, type = 'success') {
  const el = document.createElement('div');
  el.className = 'alert alert--' + type;
  el.textContent = msg;
  parent.prepend(el);
  setTimeout(() => el.remove(), 3000);
}

function badgeEstado(estado) {
  const map = {
    disponible:    'badge--green',
    alquilado:     'badge--red',
    mantenimiento: 'badge--yellow',
    activa:        'badge--blue',
    completada:    'badge--purple',
    cancelada:     'badge--gray',
  };
  return `<span class="badge ${map[estado] || 'badge--gray'}">${estado}</span>`;
}
