<?php
include "config.php";

$stmt= $conn->prepare("SELECT COUNT(*) AS total FROM users");
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$total_record = $row['total'];
$record_per_page = 5;
$total_pages = ceil($total_record/$record_per_page);



for ($i=1;$i<=$total_pages;$i++){
    echo "<a href='create.php?page=$i&sort=username&order=ASC' style='color:#37392E;'>Page $i</a>";
    
}

if(isset($_GET['page'])){
    $current_page = $_GET['page'];
}
else{
    $current_page = 1;
}

$offset = ($current_page-1)*$record_per_page;

?>

