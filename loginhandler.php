<?php
	session_start();
  header("Content-type: application/json");
	if (isset($_POST['user'])){
    $username = $_POST["user"];
    $password = $_POST["password"];

    include 'checkpassword.php';


	  if (checkPassword($username, $password)){
        $staffid = $row["staff_id"];
        $db = dblogin();
        $sqls = "SELECT * FROM `specialists` WHERE staff_id = '$staffid';";
        $sqlo = "SELECT * FROM `operators` WHERE staff_id = '$staffid';";

        if ($db->query($sqls)){
          $_SESSION["role"] = "specialist";
        } elseif ($db->query($sqlo)){
          $_SESSION["role"] = "operator";
        } else {
          echo json_encode(array(
          'success' => false,
          'msg' => 'Invalid staff role'
        ));
          $db->close();
      		exit;
        }
        $db->close();
        $_SESSION["username"] = $username;
        $_SESSION["userid"] = $staffid;
        echo json_encode(array(
          'success' => true
        ));
				exit;
			} else {
        echo json_encode(array(
        'success' => false,
        'msg' => 'Invalid username or password'
      ));
    		exit;
    	}
    }

?>
