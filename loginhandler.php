<!-- PHP code to handle the login connection with the database
Contributors - Ollie Tanner -->

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
        if (($roleresult = $db->query($sqls))->num_rows > 0){
          $_SESSION["role"] = "specialist";
          while($row = $roleresult->fetch_assoc()) {
            $_SESSION["specialist_id"] = $row["id"];
          }
        } elseif (($roleresult = $db->query($sqlo))->num_rows > 0){
          $_SESSION["role"] = "operator";
          while($row = $roleresult->fetch_assoc()) {
            $_SESSION["operator_id"] = $row["id"];
          }
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
