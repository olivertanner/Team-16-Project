<?php
  class Problem {
    public $id;
    public $typeid;
    public $desc;
    public $notes;
    public $datetime;
    public $hardwareid;
    public $osid;
    public $softwareid;
    public $status;
    public $specialistid;
    public $priority;
    public $solutionid;

  public function __construct(
    $id, $typeid, $desc, $notes, $datetime, $hardwareid, $osid, $softwareid, $status, $specialistid, $priority, $solutionid){
      $this->id = $id;
      $this->typeid = $typeid;
      $this->desc = $desc;
      $this->notes = $notes;
      $this->datetime = $datetime;
      $this->hardwareid = $hardwareid;
      $this->osid = $osid;
      $this->softwareid = $softwareid;
      $this->status = $status;
      $this->specialistid = $specialistid;
      $this->priority = $priority;
      $this->solutionid = $solutionid;
    }
}
    function addProblem(){
      include 'dblogin.php';
      $db = dblogin();

      $typeid = $this->typeid;
      $desc = $this->desc;
      $notes = $this->notes;
      $hardwareid = $this->hardwareid;
      $osid = $this->osid;
      $softwareid = $this->softwareid;
      $status = $this->status;
      $specialistid = $this->specialistid;
      $priority = $this->priority;

  	  $sql = "INSERT INTO `problems` VALUES (NULL, '$typeid', '$desc', '$notes', NOW(), '$hardwareid', $osid, '$softwareid', '$status', '$specialistid', '$priority', NULL);";
      $sqlnospec = "INSERT INTO `problems` VALUES (NULL, '$typeid', '$desc', '$notes', NOW(), '$hardwareid', $osid, '$softwareid', '$status', NULL, '$priority', NULL);";
      if ($specialistid == '') {
        $sql = $sqlnospec;
      }

      if ($db->query($sql) === TRUE){
        $problemid = $db->insert_id;
        $db->close();
        return $problemid;
      } else {
        $db->close();
        return NULL;
      }
    }
  
?>
