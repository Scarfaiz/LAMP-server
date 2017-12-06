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
	$sql = $conn->prepare("SELECT * FROM moderation_data WHERE id = :id AND username = :username AND type = 'comment' LIMIT 1;");
    	$sql->bindParam(":id", $id);
    	$sql->bindParam(":username", $username);
    	$sql->execute();
    	$ent = $sql->fetch(PDO::FETCH_ASSOC);
    	if ($ent < 1) {
	$sql = $conn->prepare("INSERT INTO moderation_data(id, username, type) VALUES(:id, :username, 'comment');");
    	$sql->bindParam(":id", $id);
    	$sql->bindParam(":username", $username);
    	$sql->execute();
	$sql = $conn->prepare("UPDATE account_data SET reputation = reputation + 10  WHERE username = :username;");
        $sql->bindParam(":username", $username);
        $sql->execute();
	}
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
