<?php
include "config.php";

// to know how many pages we need first we calculate the total no of record so we use count function and display it inside column name total
$stmt= $conn->prepare("SELECT COUNT(*) AS total FROM users");
$stmt->execute();

// we store that result in $result and convert it to asscoiated array in $row ["total"=>"value"]
$result = $stmt->get_result();
$row = $result->fetch_assoc();

//fetching the value
$total_record = $row['total'];
$record_per_page = 5; 
$total_pages = ceil($total_record/$record_per_page);//ceil round of the value like 6.4=7


//loop for creating clickable text (anchor tags) for how many pages we need (a href='create.php?page=$i) as we use get method so we pass the value in url so that it can be fetched
for ($i=1;$i<=$total_pages;$i++){
    echo "<a href='create.php?page=$i&sort=username&order=ASC' style='color:#37392E;'>Page $i</a>";
    
}
//if value is not null than store the value of current page like user click on page 2 so value of current page is 2
if(isset($_GET['page'])){
    $current_page = $_GET['page'];
}
else{
    $current_page = 1;
}
//formula to calculate offset
$offset = ($current_page-1)*$record_per_page;

?>

