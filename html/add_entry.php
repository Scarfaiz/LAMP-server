<?php

$response = array();

    if (isset($_GET['title']) && isset($_GET['address'])  && isset($_GET['city'])  && isset($_GET['working_hours']) && isset($_GET['product_range']) && isset($_GET['confirmation_status']) && isset($_GET['username']) && isset($_GET['comments'])  && isset($_GET['latitude']) && isset($_GET['longitude'])) {
    $title = $_GET['title'];
    $address = $_GET['address'];
    $city = $_GET['city'];
    $working_hours = $_GET['working_hours'];
    $product_range = $_GET['product_range'];
    $confirmation_status = $_GET['confirmation_status'];
    $username = $_GET['username'];
    $comments = $_GET['comments'];
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];

    require 'db_connect.php';
    $sql = $conn->prepare("INSERT INTO marker_data(title, address, city, working_hours, product_range, confirmation_status,  username, comments, latitude, longitude) VALUES(:title, :address, :city, :working_hours, :product_range, :confirmation_status, :username, :comments, :latitude, :longitude)");
    $sql->bindParam(":title", $title);
    $sql->bindParam(":address", $address);
    $sql->bindParam(":city", $city);
    $sql->bindParam(":working_hours", $working_hours);
    $sql->bindParam(":product_range", $product_range);
    $sql->bindParam(":confirmation_status", $confirmation_status);
    $sql->bindParam(":username", $username);
    $sql->bindParam(":comments", $comments);
    $sql->bindParam(":latitude", $latitude);
    $sql->bindParam(":longitude", $longitude);
    $result = $sql->execute();
    if ($result) {
	$sql = $conn->prepare("INSERT INTO moderation_data(id, username, type) VALUES(:id, :username, 'confirm');");
    	$sql->bindParam(":id", $id);
    	$sql->bindParam(":username", $username);
    	$sql->execute();
	$sql = $conn->prepare("UPDATE account_data SET reputation = reputation + 40, coins = coins - 1  WHERE username = :username;");
        $sql->bindParam(":username", $username);
        $sql->execute();
        $response["success"] = 1;
        $response["message"] = "Entry successfully created.";
 
        die(json_encode($response));
    } else {
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
 
        die(json_encode($response));
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    die(json_encode($response));
}
?>
