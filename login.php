<?php
// This was created in Visual Studio Code. I've used bootstrap in this demo without customizations.
// This is the first login system I've created using ajax request(s), I usually either use php action with POST method or use an api like Steam or Google.
include 'func.php';
// To test database connection, we require the db.php file. This will allow us to prevent usage if the site is not connected.
//require 'db.php'; // I found out that this is redundant as db.php is already included in the func.php file.
if(isset($_COOKIE['LOGIN_COOKIE']) && !isset($_GET['t']))
{
  echo '<script>window.location.href = "login.php?t=auth";</script>';
}
?>
<!-- Basic HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Demo Login</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/jQuery/jquery-3.3.1.js"></script>
</head>
<?php if(!isset($_GET['t'])) { ?>
<body>
<main role="main" class="container" style="margin-top: 5rem">
    <div class="row justify-content-md-center align-items-center">
      <div class="col col-md-4">
        <h3 style="text-align: center;width: 20rem;">Login Form</h3>
        <div class="card" style="width: 20rem;">
          <div class="card-body">
            <form>
              <div class="form-group" id="error" style="color: rgb(255,0,0);"></div>
              <div class="form-group" id="notice" style="color: rgb(80,220,100);"></div>
              <div class="form-group">
                <label for="login_username">Username</label>
                <input type="text" class="form-control" id="login_username" placeholder="Username">
              </div>
              <div class="form-group">
                <label for="login_password">Password</label>
                <input type="password" class="form-control" id="login_password" placeholder="Password">
              </div>
              <button type="submit" id="login_send" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script>
    /* I do rely heavily on jQuery as this was the first JS library I learned, even before attempting to learn basic JS. */
    // I reference the elements in variables purely to make it easier for myself so I don't have to type $("") everytime.
    // This is probably not the most elegant or productive way but I'm yet to learn other methods.
    var login_username = $("#login_username");
    var login_password = $("#login_password");
    var login_send = $("#login_send");
    var error = $("#error");
    var notice = $("#notice");
    // Hide the error element when the document is ready.
    $(document).ready(() => {
      error.hide();
    });
    // If error is shown, fade it out when the user clicks on one of the inputs. These will still run regardless of whether the error is showing or not.
    login_username.focus(() => {
      error.fadeOut();
    });
    login_password.focus(() => {
      error.fadeOut();
    });

    // Send the login data to PHP using ajax then perform tasks according to login results.
    login_send.click((e) => {
      e.preventDefault();
      // Disable inputs and button.
      login_username.prop('disabled', true);
      login_password.prop('disabled', true);
      login_send.prop('disabled', true);
      $.ajax({
        url: 'loginHandler.php',
        async: true,
        data: {
          'login': true,
          'username': login_username.val(),
          'password': login_password.val() /* Unsure whether this is secure, although it's only sending what the client entered.*/
        },
        type: 'post'
      }).done((res) => {
        console.log(res); // For testing purposes.
        // Parse the JSON result into an object.
        var r = JSON.parse(res);
        if(r.success == true) {
          notice.text("Logged in, redirecting you...");
          notice.fadeIn();
          setTimeout(() => {
            window.location.href = 'index.php';
          }, 2500);
        } else if(r.success == false) {
          // Set the error text according to the result.
          if(r.freason == "pwd") {
            error.text("The password entered was incorrect.");
          } else if(r.freason == "un") {
            error.text("The username entered could not be found.");
          } else if(r.freason == "un_pwd") {
            error.text("The username and/or password entered are incorrect.");
          } else if(r.freason == "un_null") {
            error.text("A username is required.");
          } else if(r.freason == "pwd_null") {
            error.text("A password is required.");
          } else if(r.freason == "err_occ") {
            error.text("An error occured, contact the site admin.");
          }
          // Show the error.
          error.fadeIn();
          // Enable inputs and button.
          login_username.prop('disabled', false);
          login_password.prop('disabled', false);
          login_send.prop('disabled', false);
        }
      });
    });
  </script>
</body>
<?php 
  } // t GET
  else if($_GET['t'] == 'new_user' && isset($_COOKIE['LOGIN_COOKIE']))
  {
    session_start();
    // clear cookie and session for last user.
    setcookie("LOGIN_COOKIE", "null", time() - 7200, "/");
    session_destroy();
    // redirect to login page.
    echo '<script>window.location.href = "login.php";</script>';
    
  } // t GET new user
  else if($_GET['t'] == 'auth' && isset($_COOKIE['LOGIN_COOKIE']))
  {
    $f = new Functions();
    $s = $f->GetSessionData($_COOKIE['LOGIN_COOKIE']);
    if($s == false)
    {
      // Since the query returned false (couldn't find the user or found more than 1 row), its possible the user aletered the cookie, so we redirect them to new_user page to clear the cookie.
      echo '<script>window.location.href = "login.php?t=new_user";</script>';
      return; // kill the page.
    }
    ?>
<body>
<main role="main" class="container" style="margin-top: 5rem">
    <div class="row justify-content-md-center align-items-center">
      <div class="col col-md-4">
        <h3 style="text-align: center;width: 20rem;">Welcome back, <?php echo $s['first_name']; ?></h3>
        <div class="card" style="width: 20rem;">
          <div class="card-body">
            <form>
              <div class="form-group" id="auth_error" style="color: rgb(255,0,0);"></div>
              <div class="form-group" id="auth_notice" style="color: rgb(80,220,100);"></div>
              <p>Enter your password below to continue</p>
              <div class="form-group">
                <input type="password" class="form-control" id="auth_password" placeholder="Password">
              </div>
              <button type="submit" id="auth_send" class="btn btn-primary" style="float:left;">Submit</button> <a href="?t=new_user" style="float:right;padding-top: 8px;">Not you?</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script>
    // Yes I am aware I just Copy+Pasted this, but I learned that C+P is a developer's best friend.
    var auth_password = $("#auth_password");
    var auth_username = "<?php echo $s['username']; ?>";
    var auth_error = $("#auth_error");
    var auth_notice = $("#auth_notice");
    var auth_send = $("#auth_send");

    // Once again, hide the error & notice elements when the document is ready and fade out when focus etc..
    $(document).ready(() => {
      auth_error.hide();
    });
    auth_password.focus(() => {
      auth_error.fadeOut();
    });

    // Send the auth data to PHP using ajax but this time, we can utilize the login system again by sending the username and password again. This will reset the cookie again.
    auth_send.click((e) => {
      e.preventDefault();
      // 
      auth_password.prop('disabled', true);
      auth_send.prop('disabled', true);
      $.ajax({
        url: 'loginHandler.php',
        async: true,
        data: {
          'login': true,
          'username': auth_username,
          'password': auth_password.val()
        },
        type: 'post'
      }).done((res) => {
        // Parse the JSON result into an object.
        var r = JSON.parse(res);
        if(r.success == true) {
          auth_notice.text("Welcome, redirecting you...");
          auth_notice.fadeIn();
          setTimeout(() => {
            window.location.href = 'index.php';
          }, 2500);
        } else if(r.success == false) {
          // Set the error text according to the result.
          if(r.freason == "pwd") {
            auth_error.text("The password entered was incorrect.");

            // Since everything BUT the password is sent by the server, all the following errors besides null or incorrect pwd is the servers fault. We still show an error to allow...
            // ...the user to be able to report such incident. This feature can be omitted if heavy beta-testing is done prior to production.
          } else if(r.freason == "un") {
            auth_error.text("An error occured, contact the site admin."); 
          } else if(r.freason == "un_pwd") {
            auth_error.text("An error occured, contact the site admin.");
          } else if(r.freason == "un_null") {
            auth_error.text("An error occured, contact the site admin.");
          } else if(r.freason == "pwd_null") {
            auth_error.text("A password is required.");
          } else if(r.freason == "err_occ") {
            auth_error.text("An error occured, contact the site admin.");
          }
          // Show the error.
          auth_error.fadeIn();
          auth_password.prop('disabled', false);
          auth_send.prop('disabled', false);
        }
      });
    });
  </script>
</body>
<?php } // else if t auth
else {
  echo '<script>window.location.href = "login.php";</script>';
} // redir to login.php  ?>
</html>