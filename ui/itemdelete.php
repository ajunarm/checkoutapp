<?php

include_once "connectdb.php";

$id = $_POST['item_id'];
$sql = "DELETE FROM tbl_items WHERE itemid = '$id'";
$delete = $pdo->prepare($sql);

if ($delete->execute())
{
}
else
{
    echo "Error deleting item";
}
