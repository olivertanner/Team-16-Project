<?php
  session_start();
  header("Content-Type: application/json");
  $username = $_SESSION["username"];
  $userid = $_SESSION["userid"];
  $role = $_SESSION["role"];
  $specialistid = $_SESSION["specialist_id"];
  $operatorid = $_SESSION["operator_id"];
  $name = $_SESSION["name"];
  echo json_encode(array(
    "username" => $username,
    "userid" => $userid,
    "role" => $role,
    "specialistid" => $specialistid,
    "operatorid" => $operatorid,
    "name" => $name
  ));
  exit;
?>
