<?php
  session_start();
  header("Content-Type: text/html");
  include 'dblogin.php';
  $targetptid = $_POST["targetptid"];
  $db = dblogin();

  $ptsql = "SELECT pt1.id, pt1.name, pt1.broad_type_id, pt2.name
  FROM `problem_types` AS pt1 LEFT JOIN `problem_types` AS pt2
  ON pt1.broad_type_id = pt2.id
  WHERE pt1.id = '$targetptid';";
  $broadid;
  $ptresult = $db->query($ptsql);

  if ($ptresult->num_rows > 0) {
    // output data of each row
    while($row = $ptresult->fetch_assoc()) {
      $broadid = $row["broad_type_id"];
    }
  }

  $sptsql = "SELECT * FROM `specialist_problem_type`;";

  $sql = "SELECT specialists.id AS specid, staff.name AS specname, problems.priority AS priority
    FROM `specialists`
    LEFT JOIN `staff` ON specialists.staff_id = staff.id
    LEFT JOIN `problems` ON specialists.id = problems.specialist_id;";

  $result = $db->query($sql);

  $specialists = array();
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

      $specid = $row["specid"];
      $specname = $row["specname"];
      $priority = $row["priority"];
      $found = false;
      foreach ($specialists as $specialist) {
        if ($specialist["specid"] == $specid) {
          $found = true;
          if ($priority>0) {
            $specialist["priority"] += $priority;
          }
        }

    }
    if (!$found){
      $arr = array(
        "specid" => $specid,
        "specname" => $specname,
        "priority" => ($priority == NULL) ? 0 : $priority,
        "ptid" => ""
      );
      array_push($specialists, $arr);
    }
  }

    $sptresult = $db->query($sptsql);
    if ($sptresult->num_rows > 0) {
      // output data of each row
      while($row = $sptresult->fetch_assoc()) {
        $currptid = $row["problem_type_id"];
        $currspid = $row["specialist_id"];
        if ($currptid == $targetptid || $currptid == $broadid){
          foreach ($specialists as &$specialist) {
            if ($specialist["specid"] == $currspid){
              if ($specialist["ptid"] != $targetptid){
                $specialist["ptid"] = $currptid;
              }
            }
            unset($specialist);
          }
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
  echo json_encode($specialists);
  $db->close();
  exit();
 ?>
