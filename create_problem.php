<!--PHP code to create a json object of a problem
Contributor: Ollie Tanner-->
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
  $problem = array(
    'id' => "",
    'typeid' =>$problemTypeId,
    'desc' =>$desc,
    'notes' =>$notes,
    'datetime' => "",
    'hardwareid' =>$hardwareId,
    'softwareid' =>$softwareId,
    'osid' =>$osId,
    'status' =>$status,
    'specialistid' =>$specialistId,
    'priority' =>$priority,
    'solutionid' =>""
  );

  echo json_encode($problem);
 ?>
