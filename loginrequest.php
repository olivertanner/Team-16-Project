<?php
  header("Content-type: application/json");
	if (isset($_POST['user'])){
		include 'dblogin.php';
		$db = dblogin();
		$username = $_POST["user"];
		$password = $_POST["password"];
		$sql = "SELECT * FROM `logins` WHERE username = '$username';";

		$result = $db->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$hash = $row["password"];
				if (password_verify($password, $hash)){
					session_start();
					$_SESSION["user"] = $username;
					$_SESSION["userid"] = $row["staffid"];
					$db->close();
          echo json_encode(array(
            'success' => true));
					exit;
				}
			}
		}
		$db->close();
    echo json_encode(array(
    'success' => false));
		exit;
	}
?>
