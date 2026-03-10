<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <?php
    include "config.php";
if(isset($_GET['id'])){
$id = $_GET['id'];

$stmt=$conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();
}
?>

<form action="" method="post">

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <label class="label" for="username">Enter your name</label><br>
    <input class="input" type="text" name="username" placeholder="enter username" value="<?php echo $row['username']; ?>">
    <br><br>

    <label class="label" for="email">Enter your email</label><br>
    <input class="input" type="email" name="email" placeholder="enter email" value="<?php echo $row['email']; ?>">
    <br><br>

    <label class="label" for="password">Enter your password</label><br>
    <input class="input" type="password" name="password" placeholder="enter password" value="<?php echo $row['password']; ?>">
    <br><br>

    <label class="label" for="phone">Enter your phone no.</label><br>
    <input class="input" type="text" name="phone" placeholder="enter Phone NO." value="<?php echo $row['phone']; ?>">
    <br><br>

    <button class="input" type="submit" name="update">update</button>

               
    
            
</form>

<?php
     if(isset($_POST['update'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];

        $stmt= $conn->prepare("UPDATE users SET username=?,email=?,password=?,phone=? WHERE id=?");
        $stmt->bind_param('ssssi',$username,$email,$password,$phone,$id);

        $stmt->execute();

         header("Location: create.php");
         exit();
     }

    
  
?>
    </div>
   
</body>
</html>

