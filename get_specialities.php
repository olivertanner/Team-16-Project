<!-- PHP code to retrieve the Specialists' speciality type from the database 
Contributors - Ollie Tanner -->

<?php
  session_start();
  header("Content-Type: text/html");
  include 'dblogin.php';

  $db = dblogin();

  $specialistid = $_SESSION["specialist_id"];

  if ($specialistid != NULL){
    $sql = "SELECT * FROM `problem_types`
    INNER JOIN `specialist_problem_type`
    ON problem_types.id = specialist_problem_type.problem_type_id
    WHERE specialist_problem_type.specialist_id = '$specialistid';";
    $problemtypes = array();
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $ptid = $row["id"];
        $ptname = $row["name"];
        $arr = array(
          'ptid' => $ptid,
          'ptname' => $ptname
      );
      array_push($problemtypes, $arr);
      }
      echo json_encode($problemtypes);
      $db->close();
      exit;
    } else {
      echo json_encode(array(
        'success' => false,
        'msg' => mysqli_error($db)
      ));
      $db->close();
      exit;
    }
  } else {
    echo json_encode(array(
      'success' => false,
      'msg' => "User is not a specialist"
    ));
    $db->close();
    exit;
  }
 ?>
