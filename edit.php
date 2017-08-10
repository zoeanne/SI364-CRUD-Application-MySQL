<?php
session_start();

if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
}

// If the user requested logout go back to index.php
// if ( isset($_POST['save']) ) {
//     header('Location: index.php');
//     return;
// }
if ( isset($_POST['cancel'] ) ) {
        header("Location: index.php");
        return;
}


require_once "pdo.php";


if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])
     && isset($_POST['mileage']) && isset($_POST['autos_id']))
     {
if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1)
  {
    $_SESSION['error'] = "All fields are required";
    header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
    return;
  }
elseif ((is_numeric($_POST['year']) == FALSE) || (is_numeric($_POST['mileage']) == FALSE))
      {
        $_SESSION['error'] = "Mileage and year must be an integer";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
     }
else
{
  $sql = "UPDATE autos SET make = :mk,
          model = :md, year = :yr, mileage = :ml
          WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
    ':mk' => htmlentities($_POST['make']),
    ':md' => htmlentities($_POST['model']),
    ':yr' => htmlentities($_POST['year']),
    ':ml' => htmlentities($_POST['mileage']),
    ':autos_id' => htmlentities($_POST['autos_id'])));
    $_SESSION['success'] = "Record edited";
    header("Location: index.php");
    return;
  }

}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

$n = htmlentities($row['make']);
$e = htmlentities($row['model']);
$p = htmlentities($row['year']);
$z = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
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
<h1>Editing Automobile</h1>
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
<input type="text" name="make" size="60" value="<?= $n ?>"/></p>
<p>Model:
<input type="text" name="model" value="<?= $e ?>"/></p>
<p>Year:
<input type="text" name="year" value="<?= $p ?>"/></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $z ?>"/></p>
<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
<input type="submit" name ='Save' value="Save">
<input type="submit" name="cancel" value="Cancel">
</form>
<?php } else { ?>
    die('Not logged in');
<?php } ?>
</div>
</body>
</html>
