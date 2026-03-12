<?php
include "../config.php";
header('content-type: application/json');

$data = json_decode(file_get_contents("php://input"),true);

if(!isset($data['email']) and !isset($data['password'])){
   echo json_encode(["message"=>"email and password required for login"]);
   exit;
}

$password = $data['password'];
$email = $data['email'];

$stmt = $conn->prepare("SELECT id,username,password,phone FROM users WHERE email=?");
$stmt->bind_param('s',$email);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows>0){
    $row = $result->fetch_assoc();
    if(password_verify($password,$row['password'])){
        echo json_encode(["message"=>"login succesful",
                         "username"=>$row['username'],
                         "id"=>$row['id'],
                         "phone"=>$row['phone']],);
    }
    else{
        echo json_decode(["message"=>"WRONG PASSWORD"]);
    }
}

else{
    echo json_encode(["message"=>"email does not exists"]);
}

$conn->close();
    

?>