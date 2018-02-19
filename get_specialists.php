<?php
  session_start();
  header("Content-Type: text/html");
  include 'dblogin.php';

  $db = dblogin();

//  $sql = "SELECT 'sp.id' AS specid, 'st.name' AS specname, 'p.priority' AS priority
  //FROM `specialists` AS s
  //LEFT JOIN `staff` AS st ON 'sp.staff_id' = 'st.id'
  //LEFT JOIN `problems` AS p ON 's.id' = 'p.specialist_id';";

  $sql = "SELECT specialists.id AS 'specid', staff.name AS 'specname', problems.priority AS 'priority'
    FROM `specialists`
    LEFT JOIN `staff` ON specialists.staff_id = staff.id
    LEFT JOIN `problems` ON specialists.id = problems.specialist_id;";

  $result = $db->query($sql);
  $workload = array();
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $specid = $row["specid"];
      $specname = $row["specname"];
      $priority = $row["priority"];
      if ($priority>0) {
        if ($workload[$specname] != NULL) {
          $workload[$specname] += $priority;
        } else {
          $workload[$specname] = $priority;
        }
      } else {
        if ($workload[$specname] == NULL) {
          $workload[$specname] = 0;
        }
      }
    }
  } else {
    echo json_encode(array(
      'success' => false,
      'msg' => mysqli_error($db)
    ));
    $db->close();
    exit;
  }
  echo json_encode($workload);
  $db->close();
  exit();
 ?>
