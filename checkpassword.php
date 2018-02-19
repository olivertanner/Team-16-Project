<!-- PHP code to handle check the password validity with the database
Contributors - Ollie Tanner -->

<?php
function checkPassword($username, $password){
  include 'dblogin.php';
  $db = dblogin();

  $sql = "SELECT * FROM `logins` WHERE username = '$username';";

  $result = $db->query($sql);
  $db->close();

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $hash = $row["password"];
      $userid = $row["staff_id"];
      return json_encode(array(
        'success' => password_verify($password, $hash),
        'userid' => $userid
      ));
    }
  }
  return json_encode(array(
    'success' => false
  ));
}
 ?>
