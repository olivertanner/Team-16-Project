<?php
session_start();
header("Content-Type: application/json");
$ptid = $_POST["specialty"];
include 'dblogin.php';

$db = dblogin();
$specialistid = $_SESSION["specialist_id"];
if ($specialistid != NULL){
  $sql = "INSERT INTO `specialist_problem_type` VALUES ('$specialistid', '$ptid');";

  $result = $db->query($sql);
  if ($result === TRUE){
    echo json_encode(array(
      'success' => true
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
} else {
  echo json_encode(array(
    'success' => false,
    'msg' => "User is not a specialist"
  ));
  $db->close();
  exit;
}

?>
