<?php

require 'db_connect.php';
if (isset($_GET['id']) && isset($_GET['username'])) { //if ID is posted than do stuffs
    $id = ($_GET['id']);
    $username = ($_GET['username']);
    //You can put user id in marker_data table and then get values from there, but for easier testing you can firstly check if user ID is found in users table and if is not than just answer in json user not found
    $sql = $conn->prepare("SELECT * FROM marker_data WHERE id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row < 1) {
        $error['success'] = 2; //Success is for easier handling on Android to know what to do next
        $error['message'] = 'Access denied!';
        die(json_encode($error));
    } else {
			$sql = $conn->prepare("SELECT * FROM moderation_data WHERE id = :id AND username = :username AND type = 'confirm' LIMIT 1;");
		        $sql->bindParam(":id", $id);
			$sql->bindParam(":username", $username);
			$sql->execute();
    			$validation = $sql->fetch(PDO::FETCH_ASSOC);
    if ($validation > 0) {
        $data['valid'] = 0;
    } else {
	$data['valid'] = 1;
	}
	    $data['id'] = $row['id'];
            $data['title'] = $row['title'];
            $data['address'] = $row['address'];
	    $data['city'] = $row['city'];
            $data['working_hours'] = $row['working_hours'];
            $data['product_range'] = $row['product_range'];
            $data['comments'] = $row['comments'];
            $data['confirmation_status'] = $row['confirmation_status'];
            $data['latitude'] = $row['latitude'];
            $data['longitude'] = $row['longitude'];
	    $data['username'] = $row['username'];
	    $data['success'] = 1;
	    $data['message'] = 'Data was read successfully';
            die(json_encode($data, JSON_UNESCAPED_UNICODE));
        }

} else {
    $error["success"] = 3;
    $error["message"] = "Access denied!";

    die(json_encode($error));
}
?>
