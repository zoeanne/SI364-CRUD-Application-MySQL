<?php



require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
  $login = 'login.php';
  $add = 'add.php';
  echo "<body>";
  echo "<div class='container'>";
  echo "<h2>Welcome to the Automobiles Database</h2>";
  echo "<p>";
  echo "<a href='".$login."'>Please log in</a>";
  echo "</p>";
  echo "<p>";
  echo "Attempt to <a href='".$add."'>add data</a> without logging in";
  echo "</p>";
;
}



if (isset($_SESSION['name']) ) {


  echo "<body>";
  echo "<div class='container'>";
  echo "<h2>Welcome to the Automobiles Database</h2>";
  echo "<p>";
  echo('<table border="1">'."\n");
  $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
  $rows = $pdo->query("SELECT count(*) FROM autos")->fetchColumn();
  if ($rows < 1) {
      echo'No Rows Found'."<br>";
      }
    else{
      echo "<thead><tr>";
      echo "<th>Make</th>";
      echo "<th>Model</th>";
      echo "<th>Year</th>";
      echo "<th>Mileage</th>";
      echo "<th>Action</th>";
      echo "</tr></thead>";
    }
  if ( isset($_SESSION['error']) ) {
      echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
      unset($_SESSION['error']);
  }
  if ( isset($_SESSION['success']) ) {
      echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
      unset($_SESSION['success']);
  }

  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      echo "<tr><td>";
      echo(htmlentities($row['make']));
      echo("</td><td>");
      echo(htmlentities($row['model']));
      echo("</td><td>");
      echo(htmlentities($row['year']));
      echo("</td><td>");
      echo(htmlentities($row['mileage']));
      echo("</td><td>");
      echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
      echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
      echo("</td></tr>\n");
    }



      $add = 'add.php';
      $logout = 'logout.php';
      echo("</table>");
      echo "<a href='".$add."'>Add New Entry</a>";
      echo "<p>";
      echo "<a href='".$logout."'>Logout</a>";
      echo "</p>";

}

?>




<!DOCTYPE html>
<html>
<head>
<title>Zoe Halbeisen's Index Page</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Custom styles for this template -->
<link href="starter-template.css" rel="stylesheet">

</head>
<body>
<div class="container">
</body>
</html>
