<?php

try {
  $host = getenv('DB_HOSTNAME');
  $port = getenv('DB_PORT');
  $dbname = getenv('DB_NAME');
  $user = getenv('DB_USERNAME');
  $pass = getenv('DB_PASSWORD');

  $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
  $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>
