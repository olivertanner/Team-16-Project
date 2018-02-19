<!--PHP code to echo problems array from the session data
Contributor: Ollie Tanner-->
<?php
  session_start();
  header('Content-Type: application/json');

  echo json_encode($_SESSION["problems"]);
  exit;
 ?>
