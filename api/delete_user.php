<?php
include "../config.php";  // adjust path if api folder is inside project
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"),true);

//getting value from postman in json if value is set store it in variable and perform the query
if(isset($data['id'])){
    $id = $data['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param('i',$id);
    
    if($stmt->execute()){
        echo json_encode(["message"=>"deletion successful"]);

    }
    else{
        echo json_encode(["error"=>$stmt->error]);
    }


}

?>