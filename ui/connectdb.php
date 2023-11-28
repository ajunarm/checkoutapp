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

try {
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_SSL_CA       => "/var/www/html/DigiCertGlobalRootCA.crt.pem",
        // If you have a client certificate and key, include them as well:
        // PDO::MYSQL_ATTR_SSL_CERT    => "/path/to/client-cert.pem",
        // PDO::MYSQL_ATTR_SSL_KEY     => "/path/to/client-key.pem",
    ];

    $dsn = 'mysql:host=tier2checkoutappserver.mysql.database.azure.com';
    $username = 'shiftlead';
    $password = 'Ch0ose T7e R!ght';

    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>