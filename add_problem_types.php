<?php
session_start();
header("Content-Type: application/json");
$name = $_POST["name"];
$broadid = $_POST["broadid"];
include 'dblogin.php';

$db = dblogin();

$sql = "INSERT INTO `problem_types` VALUES (NULL, '$name', '$broadid');";
$sqlnull = "INSERT INTO `problem_types` VALUES (NULL, '$name', NULL);";
$result;
if ($broadid != ""){
  $result = $db->query($sql);
} else {
  $result = $db->query($sqlnull);
}
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
?>
