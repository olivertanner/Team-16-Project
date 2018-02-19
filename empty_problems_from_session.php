<!--Code to empty problems from session
Contributor: Ollie Tanner-->
<?php
  session_start();
  header('Content-Type: application/json');

  $_SESSION["problems"] = NULL;
  echo json_encode(array(
    'success'=>true
  ));
  exit;
 ?>
