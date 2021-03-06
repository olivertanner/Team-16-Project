<!-- PHP code to retrieve the Software fields from the database 
Contributors - Ollie Tanner -->


<?php
  session_start();
  header("Content-Type: text/html");
  include 'dblogin.php';

  $db = dblogin();

    $sql = "SELECT * FROM `software`;";
    $rows = "";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $html = '<option>'.$row['id'].' - '.$row['name'].'</option>';
        $rows .= $html;
      }
      echo $rows;
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
 ?>
