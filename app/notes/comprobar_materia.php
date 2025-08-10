<?php
require_once '../../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8'");

$id_materia = $_POST['id_materia'] ?? '';

$stmt = $pdo->prepare("
  SELECT nombre_materia, nrc
  FROM materias
  WHERE id_materia = :id
  LIMIT 1
");
$stmt->execute([':id' => $id_materia]);
$m = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$m) {
  echo '
    <div id="alert-error" class="flex items-center justify-center text-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
      <div class="flex-1">
        <strong>Error: </strong> Materia no encontrada
      </div>
    </div>';
} else {
  echo '
    <div id="alert-success" class="flex items-center justify-center text-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50" role="alert">
      <div class="flex-1">
        <strong>Nombre: </strong>' . htmlspecialchars($m['nombre_materia']) . '<br>
        <strong>NRC: </strong>' . htmlspecialchars($m['nrc']) . '
      </div>
    </div>';
}
?>