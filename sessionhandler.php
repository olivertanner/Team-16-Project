<?php
  session_start();
  header("Content-Type: application/json");
  $username = $_SESSION["username"];
  $userid = $_SESSION["userid"];
  $role = $_SESSION["role"];
  $name = $_SESSION["name"];
  echo json_encode(array(
    "username" => $username,
    "userid" => $userid,
    "role" => $role,
    "name" => $name
  ));
  exit;
?>
