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
      return password_verify($password, $hash);
    }
  }
  return false;
}
 ?>
