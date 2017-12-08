<?php
require 'db_connect.php';
if (isset($_GET['username'])) {
	$username = ($_GET['username']);
        $sql = $conn->prepare("SELECT  * FROM entrance_data WHERE username = :username AND date = :date LIMIT 1;");
        $sql->bindParam(":username", $username);
        $sql->bindParam(":date", date("Y-m-d"));
        $sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if($row<1){
	$sql = $conn->prepare("INSERT INTO entrance_data (username, date) VALUES (:username, :date);");
    	$sql->bindParam(":username", $username);
	$sql->bindParam(":date", date("Y-m-d"));
    	$temp = $sql->execute();
	if($temp>0){
		$sql = $conn->prepare("UPDATE account_data SET reputation = reputation + 5, coins = coins + 1 WHERE username = :username;");
	        $sql->bindParam(":username", $username);
	        $response = $sql->execute();
		$result['success'] = 1;
        	$result['message'] = $response;
        	die(json_encode($result));
		}
	else {
            $error['success'] = 3;
            $error['message'] = "Access denied!";
            die(json_encode($error, JSON_UNESCAPED_UNICODE));
        }
}else {
    $error["success"] = 4;
    $error["message"] = "Invalid user!";
    die(json_encode($error));
}
} else {
    $error["success"] = 2;
    $error["message"] = "Access denied!";
    die(json_encode($error));
}
?>
