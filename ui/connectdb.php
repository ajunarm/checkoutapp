<?php

try 
{
  $options = array(
    PDO::MYSQL_ATTR_SSL_CA => 'C:\Users\nwoko\OneDrive\Desktop\DigiCertGlobalRootCA.crt.pem'
  );
  $pdo = new PDO('mysql:host=tier2checkoutappserver.mysql.database.azure.com;port=3306;dbname=tier2checkoutschema', 'shiftlead', 'Ch0ose T7e R!ght');
  // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
  echo $e->getMessage();
}

?>