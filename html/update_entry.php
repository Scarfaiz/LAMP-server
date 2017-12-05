<?php
 
$response = array();
 
if (isset($_POST['title']) && isset($_POST['address']) && isset($_POST['image']) && isset($_POST['working_hours']) && isset($_POST['product_range']) && isset($_POST['comments']) && isset($_POST['confirmation_st$
 
    $title = $_POST['title'];
    $address = $_POST['address'];
    $image = $_POST['image'];
    $working_hours = $_POST['working_hours'];
    $product_range = $_POST['product_range'];
    $comments = $_POST['comments'];
    $confirmation_status = $_POST['confirmation_status'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
 
    require 'db_connect.php';
 
    $db = new DB_CONNECT();
 
    $result = mysql_query("UPDATE marker_data SET title = '$title', address = '$address', image = '$image', working_hours = '$working_hours', product_range = '$product_range', comments = '$comments', confirmation_status = '$confirmation_status', latitude = '$latitude', longitude = '$longitude' WHERE pid = $pid");
 
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Entry successfully updated.";
 
        echo json_encode($response);
    } else {
 
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    echo json_encode($response);
}
?>
