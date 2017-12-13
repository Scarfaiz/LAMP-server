<?php

require 'db_connect.php';
if (isset($_GET['latitude']) && isset($_GET['longitude']) && isset($_GET['city'])) {
    $latitude = ($_GET['latitude']);
    $longitude = ($_GET['longitude']);
    $city = ($_GET['city']);
	try{
    $sql = $conn->prepare("SELECT id, ( 3959 * acos( cos( radians(:latitude) ) * cos( radians(latitude) )  * cos( radians(longitude) - radians(:longitude) ) + sin( radians(:latitude) ) * sin(radians(latitude)) ) ) AS distance  FROM marker_data  WHERE city = :city HAVING distance < 2  ORDER BY distance  LIMIT 0 , 20;");
    $sql->bindParam(":latitude", $latitude);
    $sql->bindParam(":longitude", $longitude);
    $sql->bindParam(":city", $city);
    $sql->execute();
    $i = 0;
	while($row = $sql->fetch(PDO::FETCH_ASSOC))
                {
			 $stmt = $conn->prepare("SELECT confirmation_status, latitude, longitude FROM marker_data WHERE id = :id;");
    			$stmt->bindParam(":id", $row["id"]);
    			$stmt->execute();
			$geodata  = $stmt->fetch(PDO::FETCH_ASSOC);
			$data["latitude"] .= $geodata["latitude"];
			$data["longitude"] .= $geodata["longitude"];
                        $data["confirmation_status"] .= $geodata["confirmation_status"];
			$data["id"] .= $row["id"];
			$data["latitude"] .= " ";
                        $data["longitude"] .= " ";
			$data["confirmation_status"] .= " ";
                        //echo json_encode($row);
                        $data["id"] .= " ";
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
