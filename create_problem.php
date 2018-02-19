<?php
  session_start();
  include 'problem.php';
  $problemTypeId = $_POST["problemTypeId"];
  $desc = $_POST["desc"];
  $notes = $_POST["notes"];
  $hardwareId = $_POST["hardwareId"];
  $softwareId = $_POST["softwareId"];
  $osId = $_POST["osId"];
  $specialistId = $_POST["specialistId"];
  $status = $_POST["status"];
  $priority = $_POST["priority"];
  $problem = new Problem("", $problemTypeId, $desc, $notes, "", $hardwareId, $softwareId, $osId, $status, $specialistId, $priority, "");
  echo json_encode($problem);
 ?>
