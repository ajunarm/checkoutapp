<?php

// $servername = "your_server_host";
// $username = "your_username";
// $password = "your_password";
// $database = "your_database";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $database);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// echo "Connected to the database successfully!";

// // Perform database operations here...

// // Close the connection
// $conn->close();

try
{
    $pdo = new PDO('mysql:host=tier2checkoutappserver.mysql.database.azure.com', 'shiftlead', 'Ch0ose T7e R!ght');
}
catch (PDOException $e)
{
    echo $e->getMessage();
}

?>