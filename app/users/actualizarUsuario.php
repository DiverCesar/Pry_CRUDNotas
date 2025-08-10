<?php
require_once '../../conexion/db.php';

//recibir datos por json
$request = json_decode(file_get_contents("php://input"), true);
$id = $request["id_usuario"];
$nombre = $request["nombre"];
$email = $request["email"];
$edad = $request["edad"];

//preparar mi query
$consulta = "UPDATE usuarios SET nombre_usuario=:nombre, email=:email, edad=:edad WHERE id_usuario = :id";

//ejecutar la consulta
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(":id", $id);
$stmt->bindParam(":nombre", $nombre);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":edad", $edad);
$stmt->execute();

//imprimir datos json
echo json_encode(['message' => 'usuario actualizado correctamente']);
?>