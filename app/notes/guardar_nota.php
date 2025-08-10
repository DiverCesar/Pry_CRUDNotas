<?php
require_once '../../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8'");

$id_usuario  = intval($_POST['id_usuario']  ?? 0);
$id_materia  = intval($_POST['id_materia']  ?? 0);
$nota1       = trim($_POST['nota1']        ?? '');
$nota2       = trim($_POST['nota2']        ?? '');
$nota3       = trim($_POST['nota3']        ?? '');

if ($id_usuario <= 0 || $id_materia <= 0 || $nota1 === '' || $nota2 === '' || $nota3 === '') {
  echo '
    <div id="alert-error" class="flex items-center justify-center text-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
      <div class="flex-1"><strong>Error:</strong> Todos los campos son obligatorios</div>
    </div>';
  exit;
}

if (!is_numeric($nota1) || !is_numeric($nota2) || !is_numeric($nota3)
    || $nota1 < 0 || $nota2 < 0 || $nota3 < 0
    || $nota1 > 100 || $nota2 > 100 || $nota3 > 100) {
  echo '
    <div id="alert-error" class="flex items-center justify-center text-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
      <div class="flex-1"><strong>Error:</strong> Las notas deben ser numéricas entre 0 y 20</div>
    </div>';
  exit;
}

$promedio = round((floatval($nota1) + floatval($nota2) + floatval($nota3)) / 3, 2);

$sql = "INSERT INTO notas 
          (id_usuario, id_materia, nota1, nota2, nota3, promedio)
        VALUES 
          (:u, :m, :n1, :n2, :n3, :prom)";
try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':u'     => $id_usuario,
    ':m'     => $id_materia,
    ':n1'    => $nota1,
    ':n2'    => $nota2,
    ':n3'    => $nota3,
    ':prom'  => $promedio,
  ]);

  echo '
    <div id="alert-success" class="flex items-center justify-center text-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50" role="alert">
      <div class="flex-1">
        Notas registradas exitosamente<br>
        Promedio: <strong>' . number_format($promedio, 2) . '</strong><br>
        </div>
    </div>';
} catch (PDOException $e) {
  echo '
    <div id="alert-error" class="flex items-center justify-center text-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
      <div class="flex-1"><strong>Error:</strong> No se pudo guardar la nota</div>
    </div>';
}
?>
