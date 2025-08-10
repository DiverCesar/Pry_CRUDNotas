<?php
// conexion db.php
$host = 'localhost';
$dbname = 'admin';
$username = 'admin';
$password = 'root';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
  // Si conecta correctamente, no imprimimos nada
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die('
    <div style="
        max-width:500px;
        margin:40px auto;
        padding:16px;
        border-left:4px solid #f56565;
        background-color:#fff5f5;
        color:#9b2c2c;
        font-family:Arial,sans-serif;
        border-radius:4px;
    ">
      <strong style="display:block; font-size:16px; margin-bottom:8px;">
        ✘ Conexión fallida
      </strong>
      <span style="font-size:14px;">
        ' . $e->getMessage() . '
      </span>
    </div>
    ');
}
