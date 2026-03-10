<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div>
        <h1>BASIC CRUD OPERATIONS</h1>
        <?php
        include "config.php";

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

        }
        
        
        ?>

        <form action="" method="post">
            <label class= "label" for="username">Enter your name</label><br>
            <input class="input" type="text" name="username" >
            <br><br>

            <label class= "label"  for="email">Enter your email</label><br>
            <input class="input" type="email" name="email" >
            <br><br>

            <label class= "label" for="password">Enter your password</label><br>
            <input class="input" type="password" name="password" >
            <br><br>

            <label class= "label" for="phone">Enter your phone no.</label><br>
            <input class="input" type="text" name="phone" >
             <br><br>
            <button type="submit">Submit</button>
            

        </form>
        <br><br>
        <?php
      

        $result = $conn->query("SELECT * FROM users");
        if ($result && $result->num_rows > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%; max-width: 600px;'><tr><th>ID</th><th>Username</th><th>Email</th><th>Password</th><th>Phone</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['username']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['password']."</td>";
                echo "<td>".$row['phone']."</td>";
                echo "<td> <a href='delete.php?id=".$row["id"]."' onclick='return confirm(\"Delete this record?\")'>Delete</a></td>";
                echo "<td><a href='update.php?id=".$row["id"]."'>update</a></td>";
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