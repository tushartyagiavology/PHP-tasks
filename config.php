<?php
 $servername="localhost";
        $username ="root";
        $password="";
        $dbname="user_account";

        $conn = new mysqli($servername,$username,$password,$dbname);     
        
        if($conn->connect_error){
            die("connection failed" . $conn->connect_error);
        }

        mysqli_query($conn, "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                phone VARCHAR(255) NOT NULL
            )
        ");
?>