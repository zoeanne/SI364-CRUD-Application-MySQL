<?php
session_start();

if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}
if ( isset($_POST['cancel'] ) ) {
        header("Location: index.php");
        return;
}


require_once "pdo.php";


if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])
     && isset($_POST['mileage']))
     {
if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1)
  {
    $_SESSION['error'] = "All fields are required";
    header("Location: add.php");
    return;
  }
elseif ((is_numeric($_POST['year']) == FALSE) || (is_numeric($_POST['mileage']) == FALSE))
      {
        $_SESSION['error'] = "Mileage and year must be an integer";
        header("Location: add.php");
        return;
     }
else
{
    $sql = "INSERT INTO autos (make, model, year, mileage)
    VALUES (:mk, :md, :yr, :ml)";
    // echo("<pre>\n".$sql."\n</pre>\n");
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
    ':mk' => htmlentities($_POST['make']),
    ':md' => htmlentities($_POST['model']),
    ':yr' => htmlentities($_POST['year']),
    ':ml' => htmlentities($_POST['mileage'])));
    $_SESSION['success'] = "Record added";
    header("Location: index.php");
    return;
  }
}



?>

<!DOCTYPE html>
<html>
<head>
<title>Zoe Halbeisen's Automobile Tracker</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Custom styles for this template -->
<link href="starter-template.css" rel="stylesheet">

</head>
<body>
<div class="container">
<h1>Tracking Automobiles for
  <?php
    echo $_SESSION['name'];
  ?>
</h1>
<p>
<?php
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}if ( isset($_SESSION['name']) ) {
?>
</p>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Model:
<input type="text" name="model" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
<?php } else { ?>
    die('Not logged in');
<?php } ?>
</div>
</body>
</html>
