<?php
  session_start();
  header("Content-Type: text/html");
  include 'dblogin.php';

  $db = dblogin();

  $sql = "SELECT * FROM `problem_types`;";

  $result = $db->query($sql);
  $html = "";
  $ptid;
  $ptname;
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $ptid = $row["id"];
      $ptname = $row["name"];
      $html .= "<option>".$ptid." - ".$ptname."</option>";
    }
  }
  echo $html;
  $db->close();
  exit();
 ?>
