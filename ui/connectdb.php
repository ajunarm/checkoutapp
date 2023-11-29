<?php

try
{
  $pdo = new PDO('mysql:host=tier2checkoutappserver.mysql.database.azure.com;port=3306;dbname=tier2checkoutschema', 'shiftlead', 'Ch0ose T7e R!ght');
}
catch (PDOException $e)
{
  echo $e->getMessage();
}

?>
