<!--PHP code for adding problem to the database
Contributor: Ollie Tanner-->
<?php
include 'dblogin.php';
function addNewProblem($problem){
  $db = dblogin();
  //$problem = json_decode($problem);
  return $problem;
  $typeid = $this->typeid;
  $desc = $this->desc;
  $notes = $this->notes;
  $hardwareid = $this->hardwareid;
  $osid = $this->osid;
  $softwareid = $this->softwareid;
  $status = $this->status;
  $specialistid = $this->specialistid;
  $priority = $this->priority;

  $sql = "INSERT INTO `problems` VALUES (NULL, '$typeid', '$desc', '$notes', NOW(), '$hardwareid', '$osid', '$softwareid', '$status', '$specialistid', '$priority', NULL);";
  $sqlnospec = "INSERT INTO `problems` VALUES (NULL, '$typeid', '$desc', '$notes', NOW(), '$hardwareid', '$osid', '$softwareid', '$status', NULL, '$priority', NULL);";
  if ($specialistid == '') {
    $sql = $sqlnospec;
  }

  if ($db->query($sql) === TRUE){
    $problemid = $db->insert_id;
    $db->close();
    return $problemid;
  } else {
    $msg = mysqli_error($db);
    $db->close();
    return $msg;
  }
}

 ?>
