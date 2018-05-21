<?php
    session_start();
    if(isset($_SESSION['LOGGED_IN']))
    {
        //echo "sesson active";
        session_destroy();
        if(isset($_COOKIE['LOGIN_COOKIE']))
        {
            setcookie("LOGIN_COOKIE", "null", time() - 7200, "/");
        }
        echo '<script>window.location.href = "login.php";</script>';
    }
    else{
        echo '<script>window.location.href = "login.php";</script>';
    }
?>