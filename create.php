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
                $email=trim($_POST["email"]);
                $password=$_POST["password"];
                $phone=$_POST["phone"];

                if(empty($username) or empty($email) or empty($password)){
                    die("<h2>ALL FIELDS ARE REQUIRED</h2>");
                }

                $stmt=$conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param('s',$email);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows>0){
                    die("<h2>Email Already Exist, Please enter a new one<h2>");
                }

                $hashedpassword = password_hash($password,PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users(username,email,password,phone) VALUES (?,?,?,?)");
                $stmt->bind_param('ssss',$username,$email,$hashedpassword,$phone);
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
      

        $result = $conn->query("SELECT * FROM users order by username ASC");
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