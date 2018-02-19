<?php
  class Call {
    public $id;
    public $callerid;
    public $operatorid;
    public $reason;
    public $datetime;

  public function __construct($id, $callerid, $operatorid, $reason, $datetime){
      $this->id = $id;
      $this->callerid = $callerid;
      $this->operatorid = $operatorid;
      $this->reason = $reason;
      $this->datetime = $datetime;
    }
  }

  function addProblemCallLink($callid, $problemid){
    include 'dblogin.php';
    $db = dblogin();
    $sql = "INSERT INTO `calls_problems` VALUES ('$callid', '$problemid');";

    if ($db->query($sql)){
      $db->close();
      return true;
    } else {
      $db->close();
      return false;
    }
  }
?>
