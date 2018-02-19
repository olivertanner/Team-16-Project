<!-- PHP code to connect to the database
Contributors - Ollie Tanner -->

<?php
function dblogin(){
  $username="root";
  $password="t16rMSpw";
  $host='localhost';
  $dbName='make_it_all';

  $db = mysqli_connect($host,$username,$password,$dbName)
 or die('Error connecting to MySQL server.');

  return $db; //return database object
}
?>
