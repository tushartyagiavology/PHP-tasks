<?php
include "../config.php";  // adjust path if api folder is inside project
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"),true); //whatever we write in json in postman is given as a php array so we are accesing element using keys 
if(!$data or !isset($data['username'], $data['email'], $data['password'], $data['phone'])){
    echo json_encode(["error" => "missing data"]);
    exit;
}

$username = $data['username'];
$email = $data['email'];
$password = password_hash($data['password'],PASSWORD_DEFAULT);
$phone = $data['phone'];

$stmt = $conn->prepare("INSERT INTO users (username,email,password,phone) values (?,?,?,?)");
$stmt->bind_param("ssss",$username,$email,$password,$phone);


//if the query execute than succesufully than encode a message in json
if($stmt->execute()){
    echo json_encode(["message"=>"user added succesfully"]);
}
else{
    echo json_encode(["error"=>$stmt->error]);
}
?>


