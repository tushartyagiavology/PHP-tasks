<?php
include "config.php";

        //checking if user entered any data in the username,email field if we getting data from there if yes tham assign those values to variables
        if($_SERVER['REQUEST_METHOD']=="POST"){
                $username=$_POST["username"];
                $email=trim($_POST["email"]);
                $password=$_POST["password"];
                $phone=$_POST["phone"];
                
                //condition that no field are left blanked
                if(empty($username) or empty($email) or empty($password)){
                    die("<h2>ALL FIELDS ARE REQUIRED</h2>");
                }
                //checking if email already exist first getting user info where email = ? using query and than checking if we get like more than 0 rows that email exist 
                $stmt=$conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param('s',$email);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows>0){
                    die("<h2>Email Already Exist, Please enter a new one<h2>");
                }
                 //hasing the password user entered
                $hashedpassword = password_hash($password,PASSWORD_DEFAULT);

                 
                // sql query for inserting data into table
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="create">
        <!-- form layout for getting user input for fileds like username,email and all give them names through which only they can be accessed through post method -->
        <h1>BASIC CRUD OPERATIONS</h1>
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
    </div>

<br><br>
<div id="div2">
    <!-- form layout for seacrh and sort options and giving names to select and values to option to values through which only they can be accessed through get method -->
    <form method="GET" action="">
        <label class="label" for="column">SORT ACCORDING TO:</label>
            <select name="sort">
                <option value="" selected disabled>Select column</option>
                <option value="username">USERNAME</option>
                <option value="email">EMAIL</option>
            </select><br><br>
        <label class="label" for="order">ORDER OF SORTING:</label>
            <select name="order">
                <option value="" selected disabled>Select order</option>
                <option value="ASC">ASCENDING ORDER</option>
                <option value="DESC">DESCENDING ORDER</option>
            </select><br><br>
            <button type = submit>SORT</button>
    </form>
<br>
    <form method="GET" action="">
        <input type="text" name="search">
        <button type="submit">Search</button>
    </form>

    
</div>
<br><br>
        
<div class="create">
        <?php
        include "pagination.php";
        $sql= "SELECT * FROM users";

        //if user clicked the search button the value inside is recieved using get method and that value is stored in $search and updates the sql query seacrhing username like.
        if(isset($_GET['search'])){
        $search = $_GET['search'];
        $sql .= " WHERE username LIKE '%$search%'";

        }
        //for sorting the records we have preasigned values like acc to username and in asc order so that we dont't get any error than we check if user has set values and get thevalues using GET request and run the sql query
        $sort_column = "username"; 
        $sort_order = "ASC";   
        if(isset($_GET['sort'])){
            $sort_column = $_GET['sort'];   
        }
        if(isset($_GET['order'])){
            $sort_order = $_GET['order'];
        }
        $sql .= " ORDER BY $sort_column $sort_order";
        

        //this is the query for pagination like how many records per page i.e limit and offset i.e from where records will start on each page
        $sql .= " LIMIT $record_per_page OFFSET $offset";


        
        //the ouput of all above sql query is stored in $result and if the result has more than 0 rows the table will be displayed and for filling the values in table we use fetch-assoc that converts $result into an associated array and store that array in $row so now vales are filled inside the tbale after that 
        // if the result has  0 rows that no records found will be displayed
    
        $result = $conn->query($sql);
        echo "<br><br>";
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
    
    <br>
<?php

$conn->close();
?>



</body>
</html>





