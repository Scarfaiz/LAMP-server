<?php

require 'db_connect.php';
if (isset($_GET['id']) && isset($_GET['comments'])) {
    $id = ($_GET['id']);
    $comments = ($_GET['comments']);
    $comments .= " anotheRcommenT ";
    $stmt = $conn->prepare("SELECT comments FROM marker_data WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $comments .= $data['comments'];
    $sql = $conn->prepare("UPDATE marker_data SET comments = :comments WHERE id = :id");
    $sql->bindParam(":id", $id);
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
