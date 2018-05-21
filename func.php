<?php
require 'db.php';

// Create a class for Functions.
class Functions
{
    protected $db;
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get the session information based on the users salt that is stored in the LOGIN_COOKIE cookie.
    // It would be safer to generate a unique 16 or 32 bit identifier to search for profiles.
    public function GetSessionData($cookie)
    {
        // escape to avoid injection.
        $salt = $this->db->Escape($cookie);

        $query = "SELECT * FROM `accounts` WHERE `salt` = '$salt'";
        $get = $this->db->Select($query);

        // If the amount of rows returned is equal to 1 continue othwise fail(false).
        if($get->num_rows == 1)
        {
            $ui = $get->fetch_assoc();
            $user = array('uid' => $ui['uid'], 'username' => $ui['username'], 'first_name' => $ui['first_name']);
            return $user;
        }
        else {
            return false;
        }
    }
}
// Create a class for User data.
class User
{
    protected $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function GetData($uid)
    {
        $uid = $this->db->Escape($uid);

        $query = "SELECT * FROM `accounts` WHERE `uid` = '$uid'";
        $get = $this->db->Select($query);
        if($get->num_rows == 1)
        {
            $r = $get->fetch_assoc();
            return $r;
        }
    }
}

?>