<?php
require_once '../../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8mb4'");

$nombre = trim($_POST['nombre_materia'] ?? '');
$nrc    = trim($_POST['nrc'] ?? '');

if ($nombre === '' || $nrc === '') {
  echo '
    <div id="alert-error" class="flex items-center justify-center text-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
      <div class="flex-1"><strong>Error:</strong> Nombre y NRC son obligatorios.</div>
    </div>';
  exit;
}

if (!is_numeric($nrc) || intval($nrc) <= 0) {
  echo '
    <div id="alert-error" class="flex items-center justify-center text-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
      <div class="flex-1"><strong>Error:</strong> El NRC debe ser un número positivo.</div>
    </div>';
  exit;
}

try {
  $stmt = $pdo->prepare("INSERT INTO materias (nombre_materia, nrc) VALUES (:n, :nr)");
  $stmt->execute([
    ':n'  => $nombre,
    ':nr' => intval($nrc),
  ]);

  echo '
    <div id="alert-success" class="flex items-center justify-center text-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50" role="alert">
      <div class="flex-1">
        Materia <strong>"' . htmlspecialchars($nombre) . '"</strong> creada exitosamente<br>
      </div>
    </div>';
} catch (PDOException $e) {
  echo '
    <div id="alert-error" class="flex items-center justify-center text-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
      <div class="flex-1"><strong>Error:</strong> No se pudo guardar la materia</div>
    </div>';
}
?>
