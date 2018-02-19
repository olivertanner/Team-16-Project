<!-- PHP code to keep the appropriate fields in the current logged in session so they can be used in the system 
Contributors - Ollie Tanner -->

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
