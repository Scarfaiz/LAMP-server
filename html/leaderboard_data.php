<?php

require 'db_connect.php';
if (isset($_GET['username'])) {
    $latitude = ($_GET['username']);
	try{
    $sql = $conn->prepare("SELECT username, reputation FROM account_data  ORDER BY reputation DESC LIMIT 0 , 100;");
    $sql->bindParam(":username", $username);
    $sql->execute();
    $i = 0;
	while($row = $sql->fetch(PDO::FETCH_ASSOC))
                {
			$data["username"] .= $row["username"];
			$data["reputation"] .= $row["reputation"];
			$data["username"] .= PHP_EOL;
                        $data["reputation"] .= PHP_EOL;
             }
    $data["success"] = 1;
    $data["message"] = "Area was searched successfully";

    die(json_encode($data, JSON_UNESCAPED_UNICODE));
        }
	 catch (PDOException $e) {
    die("Error occurred: " . $e->getMessage());
}
} else {
    $error["success"] = 0;
    $error["message"] = "Required field(s) is missing!";

    die(json_encode($error));
}
?>
