<?php // Do not put any HTML above this line

require_once "pdo.php";

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
//$stored_hash = 'a8609e8d62c043243c4e201cbb342862';  // Pw is meow123
$md5 = hash('md5', 'XyZzy12*_php123'); //Pw is php123

$failure = false;  // If we have no POST data

session_start();
// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    unset($_SESSION['email']);
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
      $_SESSION['error'] = "User name and password are required";
      header("Location: login.php");
      return;
    } elseif (!preg_match("/@/", $_POST['email'])){
      $_SESSION['error'] = "Email must have an at-sign (@)";
      header("Location: login.php");
      return;
    }
    else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $md5 ) {
            error_log("Login success ".$_POST['email']);
            $_SESSION['name'] = $_POST['email'];
            // Redirect the browser to game.php
            header("Location: index.php");
            return;
        } else {
            $_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
            header("Location: login.php");
            return;
        }
    }
}


// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<title>Zoe Halbeisen - Autos Database</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Custom styles for this template -->
<link href="starter-template.css" rel="stylesheet">

</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
</p>
<p>
  For a password hint, view source and find a password hint
  in the HTML comments.
  <!-- Hint: The password is the three character name of the
  programming language used in this class (all lower case)
  followed by 123. -->
</p>
</div>
</body>
