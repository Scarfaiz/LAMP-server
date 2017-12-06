<?php

require 'db_connect.php';
if (isset($_GET['username'])) { //if ID is posted than do stuffs
    $username = ($_GET['username']); //save ID in some variable
    $sql = $conn->prepare("SELECT reputation, coins FROM account_data WHERE username = :username");
    $sql->bindParam(":username", $username);
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row < 1) {
        $error['success'] = 2; //Success is for easier handling on Android to know what to do next
        $error['message'] = 'Access denied!';
        die(json_encode($error));
    } else {
	    $data['reputation'] = $row['reputation'];
	    $data['coins'] = $row['coins'];
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
