<?php
require_once '../../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'] ?? '';
  $email = $_POST['email'] ?? '';
  $edad = $_POST['edad'] ?? '';

  $sql = "INSERT INTO usuarios (nombre_usuario, email, edad)
            VALUES (:nombre_usuario, :email, :edad)";

  try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre_usuario', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':edad', $edad);

    if ($stmt->execute()) {
      echo '
        <div id="alert-success" class="flex items-center justify-between p-4 mb-4 mt-4 text-green-800 border-t-4 border-green-300 bg-green-50" role="alert">
          <svg class="shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z" clip-rule="evenodd"/>
          </svg>
          <div class="flex-1 text-center text-sm font-medium mx-4">
            Usuario <strong>“' . htmlspecialchars($nombre) . '”</strong> creado exitosamente<br>
            </div>
        </div>';
    } else {
      echo '
            <div id="alert-error" class="flex items-center p-4 mb-4 mt-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
              <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
              </svg>
              <div class="ms-3 text-sm font-medium">
                <div class="flex-1"><strong>Error:</strong> No se pudo guardar el usuario</div>
              </div>
              <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg p-1.5 hover:bg-red-200 inline-flex h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
              </button>
            </div>';
    }
  } catch (PDOException $e) {
    echo '
        <div id="alert-error" class="flex items-center p-4 mb-4 mt-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
          <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
          </svg>
          <div class="ms-3 text-sm font-medium">
            Error PDO: ' . htmlspecialchars($e->getMessage()) . '
          <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg p-1.5 hover:bg-red-200 inline-flex h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
          </button>
        </div>';
  }
}
?>