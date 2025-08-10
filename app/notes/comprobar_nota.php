<?php
require_once '../../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8'");

$nombre_usuario = $_POST['nombre_usuario'] ?? '';
$id_materia = $_POST['id_materia'] ?? '';

$stmt = $pdo->prepare("
  SELECT n.nota1, n.nota2, n.nota3, n.promedio
  FROM notas AS n
  INNER JOIN usuarios AS u ON u.id_usuario = n.id_usuario
  WHERE u.nombre_usuario = :un
    AND n.id_materia = :mat
  ORDER BY n.promedio DESC, n.id_nota ASC
  LIMIT 1
");
$stmt->execute([
  ':un' => $nombre_usuario,
  ':mat' => $id_materia
]);
$n = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$n) {
  echo '
    <div id="alert-error" class="flex items-center justify-center text-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
      <div class="flex-1">
        <strong>Error: </strong> Nota no encontrada para ese estudiante y materia
      </div>
    </div>';
} else {
  echo '
    <div id="alert-success" class="flex items-center justify-center text-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50" role="alert">
      <div class="flex-1">
        <strong>Nota 1: </strong>' . htmlspecialchars($n['nota1']) . '<br>
        <strong>Nota 2: </strong>' . htmlspecialchars($n['nota2']) . '<br>
        <strong>Nota 3: </strong>' . htmlspecialchars($n['nota3']) . '<br>
        <strong>Promedio: </strong>' . htmlspecialchars($n['promedio']) . '
      </div>
    </div>';
}
?>