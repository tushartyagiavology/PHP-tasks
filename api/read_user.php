<?php

include "../config.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"),true);  //$data=["username"=>"tushar", "id"=>34]

//if user enter the id in json in postman than select that user only 
if(isset($data['id'])){
   $id = $data['id'];

   $stmt= $conn->prepare("SELECT * FROM USERS WHERE id=?");
   $stmt->bind_param('i',$id);

   $stmt->execute();

   $result = $stmt->get_result();
   //if the id entered by user is not present display mean 0 record found
   if($result->num_rows>0){
    $row = $result->fetch_assoc();
    echo json_encode($row);
   }
   else{
      echo json_encode(["error"=>"user not found"]);
   }
   $stmt->close();
}

//if no id enetered display every user data
else{
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();

    $result = $stmt->get_result();
    $user= [];

    while($row=$result->fetch_assoc()){
        $user[]=$row;
    }
    echo json_encode($user);

    $stmt->close();
}


?>

