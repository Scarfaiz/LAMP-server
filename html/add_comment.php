<?php

require 'db_connect.php';
if (isset($_GET['id']) && isset($_GET['username']) && isset($_GET['comments'])) {
    $id = ($_GET['id']);
    $username = ($_GET['username']);
    $comments = ($_GET['comments']);
    $sql = $conn->prepare("INSERT INTO comments_data(id, username, comments) VALUES(:id, :username, :comments)");
    $sql->bindParam(":id", $id);
    $sql->bindParam(":username", $username);
    $sql->bindParam(":comments", $comments);
    $row = $sql->execute();
    if ($row < 1) {
        $error['success'] = 2; //Success is for easier handling on Android to know what to do next
        $error['message'] = 'Access denied!';
        die(json_encode($error));
    } else {
	    $data['success'] = 1; 
	    $data['message'] = $row;
            die(json_encode($data, JSON_UNESCAPED_UNICODE));
        }

} else {
    $error["success"] = 3;
    $error["message"] = "Access denied!";

    die(json_encode($error));
}
?>
