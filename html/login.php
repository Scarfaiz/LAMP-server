<?php
	require 'db_connect.php';
				if(isset($_GET['email']))
                		{
                        		$email = $_GET['email'];
						if(isset($_GET['password']))
						{
						$password = $_GET['password'];
                                        	$stmt = $conn -> prepare("SELECT username, reputation FROM account_data WHERE email = :email AND password = :password");
                                        	$stmt->bindParam(":email", $email);
						$stmt->bindParam(":password", $password);
                                        	$stmt->execute();
						$result = $stmt->fetch(PDO::FETCH_ASSOC);
						if ($result) {
					        $response["success"] = 1;
					        $response["message"] = "Logged in successfully.";
						$response["username"] = $result["username"];
						$response["reputation"] = $result["reputation"];
					        die(json_encode($response));
						    } else {
					        $response["success"] = 0;
					        $response["message"] = "Incorrect email or password."; 
					        die(json_encode($response));
    						}
						}
						else
						{
						$error["success"] = 2;
                                        	$error["message"] = "Password is missing";
						die(json_encode($error));
						}
					}
				else{
       				 $error["success"] = 3;
     				 $error["message"] = "Email is missing";
				 die(json_encode($error));
				}
?>
