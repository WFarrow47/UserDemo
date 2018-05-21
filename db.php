<?php
// I tend to switch between procedural and object oriented PHP.
// I have attempted to use STMT to avoid injections but for non-commercial uses, mysqli_real_escape_string apparently can suffice.
#############################################
##                                         ##
##         MYSQL DATABASE DETAILS          ##
##                                         ##
#############################################
class Database
{
  private $server   = "127.0.0.1";
  private $name     = "hg_user_demo";
  private $user     = "root";
  private $pass     = "";
  
  public function Select($query)
  {
    $mydb = new mysqli($this->server, $this->user, $this->pass, $this->name);
    if($mydb->connect_errno){
      return "Connection failed: ". $mydb->connect_error;
      exit();
    }
    $result = $mydb->query($query);
    if($mydb->error) {
      try {
        throw new Exception("MySQL error $mydb->error <br> Query:<br> $query", $mydb->errno);
      } catch(Exception $e ) {
          return "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br ><br >".nl2br($e->getTraceAsString());
      }
    }
    return $result;
    $mydb->close();
  }
  public function Insert($query)
  {
    $mydb = new mysqli($this->server, $this->user, $this->pass, $this->name);
    if($mydb->connect_errno){
      return "Connection failed: ". $mydb->connect_error;
      exit();
    }
    $mydb->query($query);
    if($mydb->error) {
      try {
        throw new Exception("MySQL error $mydb->error <br> Query:<br> $query", $mydb->errno);
      } catch(Exception $e ) {
          return "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br ><br >".nl2br($e->getTraceAsString());
      }
    }
    $mydb->close();
  }
  public function Update($query)
  {
    $mydb = new mysqli($this->server, $this->user, $this->pass, $this->name);
    if($mydb->connect_errno){
      return "Connection failed: ". $mydb->connect_error;
      exit();
    }
    $mydb->query($query);
    if($mydb->error) {
      try {
        throw new Exception("MySQL error $mydb->error <br> Query:<br> $query", $mydb->errno);
      } catch(Exception $e ) {
          return "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br ><br >".nl2br($e->getTraceAsString());
      }
    }
    $mydb->close();
  }
  public function Escape($query)
  {
    $mydb = new mysqli($this->server, $this->user, $this->pass, $this->name);
    if($mydb->connect_errno){
      return "Connection failed: ". $mydb->connect_error;
      exit();
    }
    $result = $mydb->real_escape_string($query);
    if($mydb->error) {
      try {
        throw new Exception("MySQL error $mydb->error <br> Query:<br> $query", $mydb->errno);
      } catch(Exception $e ) {
          return "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br ><br >".nl2br($e->getTraceAsString());
      }
    }
    return $result;
    $mydb->close();
  }
  /*end database class*/
}
  ?>