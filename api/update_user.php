<?php
include "../config.php";    
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"),true);
if(isset($data['id'])){
    $id=$data['id'];
    $username = $data['username'];
    $email = $data['email'];
    $phone = $data['phone'];

    $stmt = $conn->prepare("UPDATE users SET username=?, email=?, phone=? where id=?");
    $stmt->bind_param('sssi',$username,$email,$phone,$id);

    if($stmt->execute()){
        echo json_encode(["message"=>"user updated succesfully"]);
        }
    else{
        echo json_encode(["error"=>$stmt->error]);
        }

}


?>