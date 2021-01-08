
<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Willkommen in der Filmfactory!</title> 
    <meta charset="utf-8">
    <!-- responives Design-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap Design-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Einbindung des CSS-Datei-->
    <link rel="stylesheet" href="./assets/css/test_stylesheet.css">
    
    <!-- Einbindung Stylesheet für Smartphone-Bildschirme-->
    <link rel="stylesheet" media="(max-width: 640px)" href="./assets/css/html5_stylesheet_mobile.css">

    <!-- Einbindung spezieller Schriftart-->

    <!-- Hinzufügen der Icon Bibliothek-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    

</head>

<body> 
<header> 
      <!--Hinzufügen selbst erstelltes Logo-->
      <img id="logo"src="./assets/img/logo2.png" alt="logo" >
      <h1 id="title">Wilkommen in der Filmfactory</h1> 
   
   
   <!--Hinzufügen Einloggen und Warenkorb Button-->
    <?php 
    session_start();
    if(isset($_SESSION["username"])) {
        echo '<a href="myAccount.php" class="btnanmelden"><i class="fa fa-user"></i>' . $_SESSION["username"] . '</a>';
        echo '<a href="index.php?logout=1" class="btn3"><i class="fa fa-user"></i> Logout</a>'; 
        echo '<a href="myAccount.php" class="btn2"><i class="fa fa-shopping-basket"></i> Meine Tickets</a> ';
    } 
    else {
        echo '<a href="login.php" class="btn3 "><i class="fa fa-user"></i> Anmelden </a>';
        echo '<a href="http://localhost:8080/WebProgJava/register.jsp" class="btnanmelden"><i class="fa fa-user"></i> Registrieren</a>';
    }
    
    ?>
    <!--<a href="http://localhost:8080/WebProgJava/register.jsp" class="btn3"><i class="fa fa-user"></i> Anmelden/Registrieren</a> -->
    <br/>
</header>
   <!-- Navigationsmenü-->
    <nav>
        <ul>
          <br>
          <br>
            <li aria-current="page"><a href="index.php">Startseite</a></li>
            <li><a href="programm.php">Programm</a>
            </li>
            <!--Menüpunkt mit Unternavigation-->
            <li tabindex="0"><a href="#">Tauschbörse</a>
            <ul class="submenu">
                    <li><a tabindex="0" href="tradeIn.php">Angebote</a>
                    </li>
                    <li><a tabindex="0" href="tradeOut.php">Angebot erstellen</a>
                    </li>
                </ul>
            
            <li tabindex="0"><a href="anfahrt.php">Informationen</a>
            </li>
        </ul>
    </nav>
<br/>
<!--Ende Navigationsmenü-->
<h1>Deine reservierten Tickets:</h1>


<?php
require("./phphelper/dbConnEstablisher.php");
$sessionUser = $_SESSION["username"];
$query = "SELECT SUM(userorders.amount), products.* FROM userorders LEFT JOIN users ON userorders.userID = users.EMail LEFT JOIN products ON userorders.productID = products.id WHERE userID='$sessionUser' GROUP BY userorders.productID";
$result = $db->query($query);

while($row = $result->fetch())
{
    echo  '<img class="cover" src="./assets/img/'. $row["img"] .'"align="left" style="margin-left: 20em;"  alt="film1"/> <br>
    <div class="filmbeschreibung"<p><b> Anzahl reservierter Tickets: '.$row['SUM(userorders.amount)'].' </b></p> <br> '.$row["desc"].'</div>';
    

    echo'<div class="clear"></div>';
}

?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

    
</body>
</html>