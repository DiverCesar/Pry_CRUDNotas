<?php
require_once '../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8'");
$stmt = $pdo->prepare("SELECT * FROM usuarios");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lista de Usuarios</title>
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/102/102387.png">
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
  
  <style>
    body {
      height: 100%;
      width: 100%;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
      background:
        linear-gradient(rgba(0, 43, 46, 0.9), rgba(0, 43, 46, 0.9)),
        url('https://upload.wikimedia.org/wikipedia/commons/8/86/MJK51582_Gruppenbild_WikiCon_2017.jpg') center/cover no-repeat fixed;
    }

    table {
      background-color: #0288d1;
      border-radius: 0.375rem;
      border-collapse: separate;
      border-spacing: 0;
      width: 100%;
      color: white;
    }

    thead tr {
      background-color: #03a9f4;
      color: white;
    }

    th,
    td {
      padding: 0.75rem 1rem;
      text-align: left;
      vertical-align: middle;
    }

    tbody tr:nth-child(even) {
      background-color: #039be5;
    }

    tbody tr:nth-child(odd) {
      background-color: #0288d1;
    }

    tbody tr:hover {
      background-color: #0277bd;
      cursor: pointer;
    }

    .dataTables_wrapper {
      color: #000;
    }

    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_info {
      color: #fff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
      color: #fff !important;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
      background-color: #81d4fa;
      color: #000;
      border: 1px solid #0288d1;
      border-radius: 0.25rem;
      padding: 0.3rem 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      background-color: #03a9f4;
      color: #000 !important;
      border-radius: 0.25rem;
      margin: 0 2px;
      padding: 0.3rem 0.6rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background-color: #0288d1 !important;
      color: white !important;
    }

    .modal-bg {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .modal-card {
      background: #fff;
      border-radius: 12px;
      padding: 1.5rem;
      width: 90%;
      max-width: 360px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      position: relative;
    }

    .modal-card h2 {
      margin-bottom: 1rem;
      color: #C62828;
      text-align: center;
      font-weight: bold;
    }

    .modal-group {
      margin-bottom: 1rem;
      text-align: left;
    }

    .modal-group label {
      display: block;
      font-weight: bold;
      margin-bottom: .25rem;
    }

    .modal-group input {
      width: 100%;
      padding: .5rem;
      border: 1px solid #C62828;
      border-radius: 4px;
    }

    .modal-close {
      position: absolute;
      top: .5rem;
      right: .5rem;
      background: transparent;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      color: #999;
    }

    .btn-din {
      display: inline-block;
      margin: .5rem;
      padding: .8rem 1.5rem;
      font-size: 1rem;
      font-weight: bold;
      color: #fff;
      background: linear-gradient(45deg, #28c62dff, #21b71cff);
      border: 2px solid transparent;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      transition: transform .2s, background .5s;
      cursor: pointer;
      width: calc(48% - 1rem);
      max-width: 200px;
    }

    .btn-din:hover {
      transform: scale(1.05);
      background: linear-gradient(45deg, #32a410ff, #1c950eff);
      border-color: #fff;
    }

    .titulo {
      color: #fff;
      text-shadow: 2px 2px 1px rgba(0, 255, 234, 0.72);
    }

    .aceptarEliminar {
      background: linear-gradient(45deg, #b31f1fff, #aa1717ff);
    }

    .aceptarEliminar:hover {
      background: linear-gradient(45deg, #950f0fff, #770b0bff);
    }

    .btn-dino {
      display: inline-block;
      padding: .8rem 1.5rem;
      font-size: 1rem;
      font-weight: bold;
      color: #fff;
      background: linear-gradient(45deg, #b31f1fff, #aa1717ff);
      border: 2px solid transparent;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      transition: transform .2s, background .5s;
      cursor: pointer;
      width: 100%;
      max-width: 200px;
    }

    .btn-dino:hover {
      transform: scale(1.05);
      background: linear-gradient(45deg, #950f0fff, #770b0bff);
      border-color: #fff;
    }

    #btn-volver {
      position: fixed;
      top: 15px;
      left: 15px;
      width: 105px;
      background: linear-gradient(45deg, #C62828, #B71C1C);
      color: #fff;
      border: none;
      padding: .6rem 1rem;
      background: linear-gradient(45deg, #3b3b3b, #000000);
      cursor: pointer;
      z-index: 1001;
      clip-path: polygon(30% 0%, 100% 0%, 100% 100%, 30% 100%, 0% 50%);
    }

    #btn-volver span {
      margin-left: 15px;
    }

    #btn-volver:hover {
      background: linear-gradient(45deg, #646464, #353535);
    }

    .modal-card .group {
      position: relative;
      margin-bottom: 1.5rem;
    }

    .modal-card .group input,
    .modal-card .group select {
      width: 100%;
      padding: .5rem .75rem;
      border: 2px solid #C62828;
      border-radius: 4px;
      background: #fff;
      appearance: none;
      box-sizing: border-box;
      font-size: 1rem;
      line-height: 1.2;
    }

    .modal-card .group select {
      height: 2.5rem;
    }

    .modal-card .group label {
      position: absolute;
      left: .75rem;
      top: -.75rem;
      background: #fff;
      padding: 0 .25rem;
      font-size: .85rem;
      font-weight: bold;
      color: #C62828;
    }

    .dataTables_wrapper .dataTables_length select {
      width: 3.5em;
      min-width: 3.5em;
      padding: 0 0.3em 0 0.3em;
    }

    .editarDatos {
      background: linear-gradient(45deg, #e0e02fff, #d2d212ff);
    }

    .editarDatos:hover {
      background: linear-gradient(45deg, #c9c920ff, #b4b41fff);
    }

    .eliminarDatos {
      background: linear-gradient(45deg, #d82828ff, #cb1b1bff);
    }

    .eliminarDatos:hover {
      background: linear-gradient(45deg, #b31515ff, #980f0fff);
    }
  </style>
</head>

<body>

  <div class="w-full max-w-screen-xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center titulo">Lista de usuarios</h1>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table id="usuariosTable" class="w-full text-sm text-left">
        <thead>
          <tr>
            <th scope="col" class="px-6 py-3">ID</th>
            <th scope="col" class="px-6 py-3">Nombre</th>
            <th scope="col" class="px-6 py-3">Email</th>
            <th scope="col" class="px-6 py-3">Edad</th>
            <th scope="col" class="px-6 py-3">Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usuarios as $u): ?>
            <tr id="fila-<?php echo $u['id_usuario'];?>">
              <td class="px-6 py-4"><?= htmlspecialchars($u['id_usuario']) ?></td>
              <td class="px-6 py-4"><?= htmlspecialchars($u['nombre_usuario']) ?></td>
              <td class="px-6 py-4"><?= htmlspecialchars($u['email']) ?></td>
              <td class="px-6 py-4"><?= htmlspecialchars($u['edad']) ?></td>
              <td class="px-6 py-4">
                <button type="button" data-id-usuario="<?= htmlspecialchars($u['id_usuario']) ?>"
                  class="editarDatos btn-din">Editar</button>
                <button type="button" data-id-usuario="<?= htmlspecialchars($u['id_usuario']) ?>"
                  class="eliminarDatos btn-din">Eliminar</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div id="modal-editarUsuario" class="modal-bg" style="display:none; justify-content:center; align-items:center;">
    <div class="modal-card">
      <button class="modal-close" onclick="toggleModal('modal-editarUsuario')">×</button>
      <h2>Editar Usuario</h2>
      <form id="form-editarUsuario">
        <div class="modal-group">
          <div class="group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" placeholder=" " required />
          </div>
          <div class="group">
            <label for="email">Correo</label>
            <input type="email" id="email" placeholder=" " required />
          </div>
          <div class="group">
            <label for="edad">Edad</label>
            <input type="number" id="edad" placeholder=" " required />
          </div>
        </div>
        <div class="text-center">
          <button type="submit" class="btn-din w-auto mx-auto" style="width:100%">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>

  <div id="modal-alert" class="modal-bg">
    <div class="modal-card">
      <h2 id="alert-title">Título</h2>
      <p id="alert-message" style="text-align:center; margin:1rem 0;"></p>
      <div class="text-center">
        <button id="alert-ok" class="btn-din w-auto mx-auto" style="width:100%">Aceptar</button>
      </div>
    </div>
  </div>

  <div id="modal-confirm-delete" class="modal-bg">
    <div class="modal-card">
      <button class="modal-close" onclick="toggleModal('modal-confirm-delete')">×</button>
      <h2>Confirmar Eliminación</h2>
      <p id="delete-message" style="text-align:center; margin:1rem 0;"></p>
      <div id="delete-step1" class="text-center">
        <button id="btn-cancel-delete" class="btn-din">
          Cancelar
        </button>
        <button id="btn-continue-delete" class="btn-din aceptarEliminar">
          Aceptar
        </button>
      </div>
      <div id="delete-step2" style="display:none; margin-top:1rem;">
        <div class="modal-group">
          <label for="confirm-name">Escribe el nombre del usuario para confirmar</label>
          <input type="text" id="confirm-name" class="modal-group input" placeholder="Nombre de usuario" required />
        </div>
        <div class="text-center w-auto mx-auto">
          <button id="btn-final-delete" class="btn-dino">
            Eliminar permanentemente
          </button>
        </div>
      </div>
    </div>
  </div>
  <button onclick="history.back()" id="btn-volver" class="btn-din"><span>Regresar</span></button>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#usuariosTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50]
      });
    });
  </script>

  <script>
    function toggleModal(id) {
      const m = document.getElementById(id);
      m.style.display = (m.style.display === 'flex') ? 'none' : 'flex';
    }

    function showAlert(type, message) {
      const modal = document.getElementById('modal-alert');
      const title = document.getElementById('alert-title');
      const msg = document.getElementById('alert-message');

      if (type === 'error') {
        title.textContent = 'Error';
        title.style.color = '#C62828';
      } else {
        title.textContent = 'Éxito';
        title.style.color = '#2F855A';
      }
      msg.innerHTML = message;
      modal.style.display = 'flex';
    }

    const tablaUsuarios = document.getElementById('usuariosTable');
    const modalUsuario = document.getElementById('modal-editarUsuario');
    const formEditar = document.getElementById('form-editarUsuario');
    let usuarioId = null;

    tablaUsuarios.addEventListener('click', event => {
      if (!event.target.classList.contains('editarDatos')) return;
      usuarioId = event.target.dataset.idUsuario;

      fetch('users/buscarUsuarioId.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_usuario: usuarioId })
      })
        .then(res => {
          if (!res.ok) throw new Error(`HTTP status ${res.status}`);
          return res.json();
        })
        .then(data => {
          document.getElementById('nombre').value = data.nombre_usuario || '';
          document.getElementById('email').value = data.email || '';
          document.getElementById('edad').value = data.edad || '';
          toggleModal('modal-editarUsuario');
        })
        .catch(err => {
          console.error('Error al cargar usuario:', err);
          showAlert('error', `<strong>Error:</strong> No se pudo cargar los datos del usuario <br>${err}`);
        });
    });

    formEditar.addEventListener('submit', async e => {
      e.preventDefault();
      const nuevoNombre = document.getElementById('nombre').value;

      const payload = {
        id_usuario: usuarioId,
        nombre: document.getElementById('nombre').value,
        email: document.getElementById('email').value,
        edad: document.getElementById('edad').value
      };

      try {
        const res = await fetch('users/actualizarUsuario.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        if (!res.ok) throw new Error(`HTTP status ${res.status}`);
        const json = await res.json();
        toggleModal('modal-editarUsuario');
        showAlert('success', `Usuario <strong>"${nuevoNombre}"</strong> actualizado correctamente`);

        document.getElementById('alert-ok').onclick = () => {
          toggleModal('modal-alert');
          location.reload();
        };
      } catch (err) {
        console.error('Error al actualizar:', err);
        showAlert('error', err.message || `<strong>Error:</strong> No se puede actualizar el usuario<br>${err.message}`);
      }
    });

    document.getElementById('alert-ok').onclick = () => {
      document.getElementById('modal-alert').style.display = 'none';
    };
  </script>

  <script>
    let deleteId = null;
    let deleteName = '';

    tablaUsuarios.addEventListener('click', event => {
      if (!event.target.classList.contains('eliminarDatos')) return;
      deleteId = event.target.dataset.idUsuario;
      deleteName = event.target.closest('tr').querySelector('td:nth-child(2)').textContent;
      document.getElementById('delete-message').textContent =
        `¿Seguro que deseas eliminar al usuario "${deleteName}"? Esta acción no se puede deshacer`;
      document.getElementById('delete-step1').style.display = 'block';
      document.getElementById('delete-step2').style.display = 'none';
      document.getElementById('confirm-name').value = '';

      toggleModal('modal-confirm-delete');
    });

    document.getElementById('btn-cancel-delete').onclick = () => {
      toggleModal('modal-confirm-delete');
    };

    document.getElementById('btn-continue-delete').onclick = () => {
      document.getElementById('delete-step1').style.display = 'none';
      document.getElementById('delete-step2').style.display = 'block';
    };

    document.getElementById('btn-final-delete').onclick = async () => {
      const confirmValue = document.getElementById('confirm-name').value.trim();
      if (confirmValue !== deleteName) {
        toggleModal('modal-confirm-delete');
        showAlert('error', 'El nombre de usuario ingresado no coincide; no se puede eliminar');
        return;
      }

      try {
        const res = await fetch('users/eliminarUsuario.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id_usuario: deleteId })
        });
        if (!res.ok) throw new Error(`HTTP status ${res.status}`);
        await res.json();

        toggleModal('modal-confirm-delete');
        showAlert('success', `Usuario <strong>"${deleteName}"</strong> eliminado correctamente`);
        document.getElementById('alert-ok').onclick = () => {
          toggleModal('modal-alert');
          var fila = document.getElementById('fila-' + deleteId);
          fila.remove();
        };
      } catch (err) {
        toggleModal('modal-confirm-delete');
        showAlert('error', `<strong>Error:</strong> no se pudo eliminar<br>${err.message}`);
      }
    };

    document.getElementById('alert-ok').onclick = () => {
      document.getElementById('modal-alert').style.display = 'none';
    };
  </script>

</body>

</html>