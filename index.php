<?php
    session_start();
    require 'func.php';
    $f = new Functions();
    $u = new User();
    if(isset($_COOKIE['LOGIN_COOKIE']) && !isset($_SESSION['LOGGED_IN']))
    {
        // Redirect the user to the authorization page.
        echo '<script>window.location.href = "login.php?t=auth";</script>';
    }
    $uInfo = $u->GetData($_SESSION['uid']);
    // There's probably a more eye-pleasing way.
    if(isset($_SESSION['LOGGED_IN']))
    { ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Demo Index</title>
            <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
            <script src="assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="assets/jQuery/jquery-3.3.1.js"></script>
        </head>
        <body>
            <main role="main" class="container">
            <h1 class="mt-5">Welcome, <?php echo $uInfo['first_name']; ?></h1>
            <p class="lead">This is your dashboard, you're currently logged in </p>
            <p>Use <a href="logout.php">this link</a> to logout.</p>
            <h4>Your account information</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Database ID:</td>
                        <td><?php echo $uInfo['id']; ?></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td><?php echo $uInfo['username']; ?></td>
                    </tr>
                    <tr>
                        <td>Unique Account ID:</td>
                        <td><?php echo $uInfo['uid']; ?></td>
                    </tr>
                    <tr>
                        <td>First Name:</td>
                        <td><?php echo $uInfo['first_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Last:</td>
                        <td><?php echo $uInfo['last_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Age:</td>
                        <td><?php echo $uInfo['age']; ?></td>
                    </tr>
                    <tr>
                        <td>Likes Coffee?</td>
                        <td><?php 
                        $is_admin = ($uInfo['likes_coffee'] == 1) ? "Yes" : "No"; echo $is_admin; ?></td>
                    </tr>
                </tbody>
            </table>

            </main>
        </body>
        </html>
<?php }
    else 
    {
        echo '<script>window.location.href = "login.php";</script>'; 
    }
?>
