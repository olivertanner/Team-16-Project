<?php
  session_start();
  header("Content-Type: application/json");
  $username = $_SESSION["username"];
  $userid = $_SESSION["userid"];
  $role = $_SESSION["role"];
  echo json_encode(array(
    "username" => $username,
    "userid" => $userid,
    "role" => $role
  ));
  exit;
?>
