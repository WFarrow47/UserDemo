<?php
// I created my own database class in db.php with specific functions.
include 'db.php';
$db = new Database();
if(isset($_POST['login']))
{
    $username = $db->Escape($_POST['username']);
    $password = $db->Escape($_POST['password']);

    if(empty($username))
    {
        // Show empty username error
        $result = array('success' => false, 'freason' => "un_null");
        echo json_encode($result);
    }
    else if(empty($password))
    {
        // Show empty password error.
        $result = array('success' => false, 'freason' => "pwd_null");
        echo json_encode($result);
    }
    else
    {
        // Check the database for their account.
        // For the purpose of this example, we can assume that their password has been salted and hashed...
        // ... with the salt being  uniqid(mt_rand(), true) and the hash being SHA-256. I'm not sure whether SHA-256 is deprecated.
        $salt_query = "SELECT `salt` FROM `accounts` WHERE `username` = '$username'";
        $get_salt_query = $db->Select($salt_query);

        if($get_salt_query->num_rows == 1)
        {
            $salt = $get_salt_query->fetch_assoc(); // I am aware it is redundant to use an assoc for one result. You could just use fetch_array.
            // Salt and hash the password for comparison.
            $sh_pass = hash('SHA256', $password.$salt['salt']);
            // Perform query to check that the password is correct.
            $login_query = "SELECT * FROM `accounts` WHERE `username` = '$username' AND `password` = '$sh_pass'";
            $get_login_query = $db->Select($login_query);
            // This method assumes that on registering, username's cannot be reused and if the query fails to get any row...
            // ... that the password must be incorrect. It's already determined if the username is incorrect when we searched for the salt.
            if($get_login_query->num_rows == 1)
            {
                $a = $get_login_query->fetch_assoc();
                // Login User, begin session and add cookie.
               
                // I know using the users salt will expose it in plain text in the browser's console but I haven't used cookies much since what I have made previously...
                // ... never really required them. Only sessions.
                setcookie("LOGIN_COOKIE", $salt['salt'], time() + 3600, "/");
                // Start the session.
                session_start();
                $_SESSION['uid'] = $a['uid'];
                $_SESSION['username'] = $username;
                $_SESSION['LOGGED_IN'] = true;
                // Send Success.
                $result = array('success' => true);
                echo json_encode($result);
            }
            else if($get_login_query->num_rows > 1)
            {
                // An error occured.
                $result = array('success' => false, 'freason' => "err_occ");
                echo json_encode($result);
            }
            else
            {
                // Incorrect password. This can be altered to say Unknown password or username.
                $result = array('success' => false, 'freason' => "pwd"); // un_pwd for both.
                echo json_encode($result);
            }
        }
        else if($get_salt_query->num_rows > 1) {
            // An error occured.
            $result = array('success' => false, 'freason' => "err_occ");
            echo json_encode($result);
        }
        else {
            // Unknown username. This can be altered to say Unknown password or username.
            $result = array('success' => false, 'freason' => "un"); // un_pwd for both.
            echo json_encode($result);
        }
    }
}
?>