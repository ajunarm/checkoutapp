<?php 
include_once'connectdb.php';

$barcode = $_GET["id"];

$select = $pdo->prepare("SELECT * FROM tbl_items WHERE barcode=$barcode");
$select->execute();

$row =  $select->fetch(PDO::FETCH_ASSOC);

$response = $row;

header('Content-Type: application/json');
echo json_encode($response);

?>
