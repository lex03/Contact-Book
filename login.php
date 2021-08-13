<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="./assets/style.css"/>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-red-100 via-white to-white ">
<?php
    require('db.php');           //imports the db.php file
    // When form submitted, check and create user session.
    if (isset($_POST['email'])) {
        $mail = stripslashes($_REQUEST['email']);    // removes backslashes
        //do with name 
        $mail = mysqli_real_escape_string($con, $mail);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE email='$mail'
                     AND pass='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['email'] = $mail;
            echo $_SESSION['email'];
            $row = mysqli_fetch_assoc($result);
            $_SESSION['name'] = $row['name'];
            echo $_SESSION['name'];
            // Redirect to user main page
            echo "Successfully logged in";
            header("Location: index.php");
        } 
        else { //displays error message 
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
             }
    } else {
?>
    <form class="form" method="post" name="login">
        <h2 class="login-title text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncat py-4">Login</h2>
        <input type="email" class="login-input" name="email" placeholder="Email" autofocus="true" required/>
        <input type="password" class="login-input" name="password" placeholder="Password" required/>
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link">Don't have an account? <a href="registration.php">Registration Now</a></p>
  </form>
<?php
    }
?>
</body>
</html>