<?php
	require 'db_connect.php';
	if(isset($_GET['email']))
		{
			$email = $_GET['email'];
			$stmt = $conn -> prepare("SELECT * FROM account_data WHERE email = :email LIMIT 1");
			$stmt->bindParam(":email", $email);
			$stmt->execute();
			$check_email = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($check_email) {
			$error["success"] = 3;
			$error["message"] = "User with this email already exists";
        		die(json_encode($error));
			}
			else {
				if(isset($_GET['username']))
                		{
                        		$username = $_GET['username'];
                        		$stmt = $conn -> prepare("SELECT * FROM account_data WHERE username = :username LIMIT 1");
                        		$stmt->bindParam(":username", $username);
                        		$stmt->execute();
                        		$check_username = $stmt->fetch(PDO::FETCH_ASSOC);
                        		if ($check_username) {
                        		$error["success"] = 4;
                        		$error["message"] = "User with this name already exists";
                        		}
					else {
						if(isset($_GET['password']))
						{
						$password = $_GET['password'];
                                        	$stmt = $conn -> prepare("INSERT INTO account_data(email, username, password, reputation) VALUES(:email, :username, :password, 0)");
						$stmt->bindParam(":email", $email);
                                        	$stmt->bindParam(":username", $username);
						$stmt->bindParam(":password", $password);
                                        	$result = $stmt->execute();
						if ($result) {
					        $response["success"] = 6;
					        $response["message"] = "Entry successfully created.";
					        die(json_encode($response));
						    } else {
					        $response["success"] = 0;
					        $response["message"] = "Oops! An error occurred."; 
					        die(json_encode($response));
    						}
						}
						else
						{
						$error["success"] = 5;
                                        	$error["message"] = "Password is missing";
						}
					}
					}
				else{
       				 $error["success"] = 2;
     				 $error["message"] = "Username is missing";
				}
			}
		die(json_encode($error));
		}
	else{
	$error["success"] = 1;
	$error["message"] = "Email is missing";
	die(json_encode($error));
}
?>
