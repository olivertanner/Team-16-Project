<?php
function dblogin(){
  $username="root";
  $password="t16rMSpw";
  $host='localhost';
  $dbName='make_it_all';

  $dsn = "mysql://$username:$password@$host/$dbName"; //Data Source Name

  require_once('MDB2.php');
  $db =& MDB2::connect($dsn); //try to make a connection

  if (PEAR::isError($db)) { //if error connecting
      die($db->getMessage());
  }
  $db->setFetchMode(MDB2_FETCHMODE_ASSOC);
  return $db; //return database object
}
?>
