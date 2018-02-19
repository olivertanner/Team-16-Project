<!-- PHP code to allow the operator to add a new operator / specialist into the database
Contributors - Ollie Tanner -->
<?php
session_start();
header("Content-Type: application/json");
$name = $_POST["name"];
$username = $_POST["username"];
$option = $_POST["option"];
include 'dblogin.php';
include 'passwords.php';

$password = generatePasswordX();
$hash = password_hash($password, PASSWORD_BCRYPT);
$role = ($option == 0) ? "Operator" : "Specialist";

$db = dblogin();
$staffid;
$staffsql = "INSERT INTO `staff` VALUES (NULL, '$name', '$role', '1');";
if ($db->query($staffsql)){
  $staffid = $db->insert_id;
  if ($staffid != NULL){
    $loginsql = "INSERT INTO `logins` VALUES ('$username', '$hash', '$staffid');";
    $specsql = "INSERT INTO `specialists` VALUES (NULL, '$staffid');";
    $opsql = "INSERT INTO `operators` VALUES (NULL, '$staffid');";
    if (!$db->query($loginsql)){
      echo json_encode(array(
        'success' => false,
        'msg' => mysqli_error($db)
      ));
      $db->close();
      exit;
    }
    if ($option == 0){
      if (!$db->query($opsql)){
        echo json_encode(array(
          'success' => false,
          'msg' => mysqli_error($db)
        ));
        $db->close();
        exit;
      }
    } else {
      if (!$db->query($specsql)){
        echo json_encode(array(
          'success' => false,
          'msg' => mysqli_error($db)
        ));
        $db->close();
        exit;
      }
    }
  }
  echo json_encode(array(
    'success' => true,
    'username' => $username,
    'password' => $password
  ));
  $db->close();
  exit;
} else {
  echo json_encode(array(
    'success' => false,
    'msg' => mysqli_error($db)
  ));
  $db->close();
  exit;
}
?>
