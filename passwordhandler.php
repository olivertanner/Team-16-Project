<!-- PHP code to handle check the password validity with the database
Contributors - Ollie Tanner -->

<?php
  session_start();
  header("Content-Type: application/json");
  $username = $_SESSION["username"];
  $currpass = $_POST["curr_pass"];
  $newpass = $_POST["new_pass"];

  include 'checkpassword.php';

  if(checkPassword($username, $currpass)){
    $hash = password_hash($newpass, PASSWORD_BCRYPT);

    $db = dblogin();
    $sql = "UPDATE `logins` SET password = '$hash' WHERE username = '$username';";
    if($db->query($sql) === TRUE){
      $db->close();
      echo json_encode(array(
        'success' => true
      ));
      exit;
    } else {
      echo json_encode(array(
        'success' => false,
        'error' => 1,
        'msg' => mysqli_error($db)
      ));
      $db->close();
      exit;
    }
  } else {
    echo json_encode(array(
      'success' => false,
      'error' => 0,
      'msg' => 'Incorrect current password'
    ));
    exit;
  }
 ?>
