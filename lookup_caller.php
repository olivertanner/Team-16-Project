<?php
  session_start();
  header('Content-Type: application/json');
  $searchstr = $_POST["search"];
  include 'dblogin.php';
  $db = dblogin();

  $sql = "SELECT * FROM `staff` WHERE name LIKE '%$searchstr%';";

  $result = $db->query($sql);
  $options = array();
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $name = $row["name"];
      $job = $row["job_title"];
      $deptid = $row["dept_id"];
      $deptname;
      $deptsql = "SELECT * FROM `dept` WHERE id = '$deptid';";

      $deptresult = $db->query($deptsql);

      if ($deptresult->num_rows > 0) {
        // output data of each row
        while($deptrow = $deptresult->fetch_assoc()) {
          $deptname = $deptrow["name"];
          }
        }
      $arr = array(
        'id' => $id,
        'name' => $name,
        'job' => $job,
        'dept' => $deptname
      );
      array_push($options, $arr);
    }
   echo json_encode($options);
   $db->close();
   exit;
}
echo "";
$db->close();
exit;
 ?>
