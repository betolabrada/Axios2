<?php

// //  DATOS DEL SERVIDOR
// $servername = "localhost";
// $username = "facilit1_admin";
// $password = "ALPQD3CbBmtUzjV";
// $database = "facilit1_axios_dev_db";

// PRUEBAS EN XAMPP
$servername = "localhost";
$username = "root";
$password = "";
$database = "facilit1_axios_dev_db";

//  CONEXION AL SERVIDOR
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}else{
    //echo("Conexión exitosa <br>");
    mysqli_select_db($conn, $database);
    if ($result = mysqli_query($conn, "SELECT DATABASE()")) {
        $row = mysqli_fetch_row($result);
        //printf("Default database is %s.\n", $row[0]);
        mysqli_free_result($result);

    }else{
        echo "Error al conectarse a la base de datos";
    }
}

?>
