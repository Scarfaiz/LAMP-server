<?php
require 'db_connect.php';
if (isset($_GET['id']) && isset($_GET['username']) && isset($_GET['confirmation_status'])) {
    $id = ($_GET['id']);
    $username = ($_GET['username']);
    $confirmation_status = ($_GET['confirmation_status']);
    $sql = $conn->prepare("SELECT * FROM moderation_data WHERE id = :id AND username = :username AND type = 'confirm' LIMIT 1;");
    $sql->bindParam(":id", $id);
    $sql->bindParam(":username", $username);
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row > 0) {
        $error['success'] = 0; //Success is for easier handling on Android to know what to do next
        $error['message'] = 'Invalid user!';
        die(json_encode($error));
    } else {
	$sql = $conn->prepare("INSERT INTO moderation_data(id, username, type) VALUES(:id, :username, 'confirm');");
    	$sql->bindParam(":id", $id);
    	$sql->bindParam(":username", $username);
    	$sql->execute();
	$stmt = $conn->prepare("UPDATE marker_data SET confirmation_status = confirmation_status + :confirmation_status WHERE id = :id;");
    	$stmt->bindParam(":id", $id);
    	$stmt->bindParam(":confirmation_status", $confirmation_status);
	$data = $stmt->execute();
	if ($data > 0) {
	$sql = $conn->prepare("UPDATE account_data SET reputation = reputation + 40, coins = coins - 1  WHERE username = :username;");
        $sql->bindParam(":username", $username);
        $sql->execute();
        $error['success'] = 1; //Success is for easier handling on Android to know what to do next
        $error['message'] = $data;
        die(json_encode($error));
	}
 	else {
            $error['success'] = 3;
            $error['message'] = "Access denied!";
            die(json_encode($error, JSON_UNESCAPED_UNICODE));
        }
}

} else {
    $error["success"] = 2;
    $error["message"] = "Access denied!";
    die(json_encode($error));
}
?>
