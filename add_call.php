<?php
  session_start();
  header('Content-Type: application/json');
  include 'call.php';
  include 'problem.php';
  include 'dblogin.php';

  $callerid = $_POST["callerid"];
  $operatorid = $_POST["operatorid"];
  $reason = $_POST["reason"];
  $problems = $_POST["problems"];
  $db = dblogin();

  $sql = "INSERT INTO `calls` VALUES (NULL, '$callerid', '$operatorid', NOW(), '$reason');";
  $result = $db->query($sql);
  if ($result === TRUE){
    $callid = $db->insert_id;
    foreach ($problems as $problem) {
      $problemid = addProblem($problem);
      if ($problemid != NULL){
        addProblemCallLink($callid, $problemid);
      }
    }
  } else {
    echo json_encode(array(
      'success'=> false,
      'msg'=> mysqli_error($db)
    ));
    $db->close();
    exit;
  }
  $db->close();
  exit;
 ?>
