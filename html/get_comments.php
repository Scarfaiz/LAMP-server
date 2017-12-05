<?php

require 'db_connect.php';
if (isset($_GET['id'])) { //if ID is posted than do stuffs
    $id = ($_GET['id']); //save ID in some variable
    try{
    $sql = $conn->prepare("SELECT username, comments FROM comments_data WHERE id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();
   	    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
            $data['username'] .= $row['username'];
            $data['comments'] .= $row['comments'];
	    $data['username'] .= PHP_EOL;
            $data['comments'] .= PHP_EOL;
        }
	$data['success'] = 1;
        $data['message'] = 'Data was read successfully';
        die(json_encode($data, JSON_UNESCAPED_UNICODE));
}
	catch (PDOException $e) {
		$error["success"] = 0;
		$error["message"] =  $e->getMessage();
        	die(json_encode($error, JSON_UNESCAPED_UNICODE));
}

} else{
    $error["success"] = 0;
    $error["message"] = "Access denied!";
    die(json_encode($error));
}
?>
