<!--PHP code to store problems in session data
Contributor: Ollie Tanner-->
<?php
  session_start();
  header('Content-Type: application/json');

  $problem = $_POST["problem"];
  if (!isset($_SESSION["problems"])) {
    $_SESSION["problems"] = array();
  }
  $_SESSION["problems"][] = $problem;
  echo json_encode(array(
    'success'=>true
  ));
  exit;
 ?>
