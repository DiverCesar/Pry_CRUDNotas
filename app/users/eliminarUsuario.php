<?php
require_once '../../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8'");

$req = json_decode(file_get_contents('php://input'), true);
$id = $req['id_usuario'] ?? 0;

try {
    $pdo->beginTransaction();
    $pdo->prepare("DELETE dp FROM detalle_pedido dp
                 JOIN pedidos p ON dp.id_pedido = p.id_pedido
                 WHERE p.id_usuario = :id")
        ->execute([':id' => $id]);

    $pdo->prepare("DELETE FROM pedidos WHERE id_usuario = :id")
        ->execute([':id' => $id]);

    $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id")
        ->execute([':id' => $id]);

    $pdo->commit();
    header('Content-Type: application/json');
    echo json_encode(['message' => "Usuario eliminado correctamente"]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Error al eliminar el usuario']);
}
?>