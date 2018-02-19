<?php
	session_start();
  header("Content-type: application/json");
	if (isset($_POST['user'])){
    $username = $_POST["user"];
    $password = $_POST["password"];

    include 'checkpassword.php';

    $result = json_decode(checkPassword($username, $password));
	  if ($result->success){
        $userid = $result->userid;
        $db = dblogin();
        $sqls = "SELECT * FROM `specialists` WHERE staff_id = '$userid';";
        $sqlo = "SELECT * FROM `operators` WHERE staff_id = '$userid';";
        $staffsql = "SELECT * FROM `staff` WHERE id = '$userid';";
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
        $staffresult = $db->query($staffsql);
        if ($staffresult->num_rows > 0) {
    	    // output data of each row
    	    while($row = $staffresult->fetch_assoc()) {
            $name = $row["name"];
            $_SESSION["name"] = $name;
          }
        }
        $db->close();
        $_SESSION["username"] = $username;
        $_SESSION["userid"] = $userid;
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
