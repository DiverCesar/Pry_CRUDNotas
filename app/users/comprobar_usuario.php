<?php
require_once '../../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8'");

$nombre_usuario = $_POST['nombre_usuario'] ?? '';

$stmt = $pdo->prepare("SELECT nombre_usuario, edad, email FROM usuarios WHERE nombre_usuario = :e");
$stmt->execute([':e' => $nombre_usuario]);
$u = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$u) {
  echo '
    <div id="alert-error" class="flex items-center justify-center text-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
      <div class="flex-1">
        <strong>Error: </strong> Usuario no encontrado
      </div>
    </div>';
} else {
  echo '
    <div id="alert-success" class="flex items-center justify-center text-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50" role="alert">
      <div class="flex-1">
        <strong>Usuario: </strong> ' . htmlspecialchars($u['nombre_usuario']) . '<br>
        <strong>Edad: </strong> ' . $u['edad'] . '<br>
        <strong>Email: </strong> ' . htmlspecialchars($u['email']) . '
      </div>
    </div>';
}
?>