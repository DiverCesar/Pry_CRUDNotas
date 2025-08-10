<?php
header('Content-Type: application/json; charset=UTF-8');
require_once '../../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8mb4'");
$stmt = $pdo->query("SELECT id_usuario, nombre_usuario FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($usuarios);
?>