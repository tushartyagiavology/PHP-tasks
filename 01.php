<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table, th, td {
        border: 2px solid #087e8b;
        color:#3c3c3c;
        background-color:#ff5a5f;
        padding: 8px;
        text-align: left;
    }

</style>
<body>
    <div style="align-items: center; display: flex; flex-direction: column; justify-content:center  ; height: 100vh;">
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

        if(isset($_GET['delete'])){
            $id=$_GET['delete'];
            $stmt=$conn->prepare("DELETE FROM users WHERE ID=?");
            $stmt->bind_param('i',$id);
            $stmt->execute();

            header("Location: ".$_SERVER['PHP_SELF']);
            exit;

        }



       
        if($_SERVER['REQUEST_METHOD']=="POST"){
                $username=$_POST["username"];
                $email=$_POST["email"];
                $password=$_POST["password"];
                $phone=$_POST["phone"];

                $stmt = $conn->prepare("INSERT INTO users(username,email,password,phone) VALUES (?,?,?,?)");
                $stmt->bind_param('ssss',$username,$email,$password,$phone);
                if($stmt->execute()){
                    echo "Data added succesfully";
                }
                else{
                    die("error: " . $stmt->error);
                }
                $stmt->close();

             header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        
        
        ?>

        <form method ="post" action="" >
        <input type="text" name="username" placeholder="username">
        <br><br>
        <input type="email" name="email" placeholder="email">
        <br><br>
        <input type="password" name="password" placeholder="password">
        <br><br>
        <input type="text" name="phone" placeholder="phone number">
        <br><br>    
        <button type="submit">Submit Form</button>
        </form>
         <br><br>
        <?php
      

        $result = $conn->query("SELECT * FROM users");
        if ($result && $result->num_rows > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%; max-width: 600px;'><tr><th>ID</th><th>Username</th><th>Email</th><th>Password</th><th>Phone</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['id'])."</td>";
                echo "<td>".htmlspecialchars($row['username'])."</td>";
                echo "<td>".htmlspecialchars($row['email'])."</td>";
                echo "<td>".htmlspecialchars($row['password'])."</td>";
                echo "<td>".htmlspecialchars($row['phone'])."</td>";
                echo "<td> <a href='?delete=".$row["id"]."' onclick='return confirm(\"Delete this record?\")'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No records found.</p>";
        }
        ?>

    </div>
    
<?php
$conn->close();
?>
</body>
</html>