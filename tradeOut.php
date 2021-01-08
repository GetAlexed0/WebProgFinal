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

<?php
require("./phphelper/dbConnEstablisher.php");
session_start();
if(isset($_SESSION["username"]))
{
    $username = $_SESSION["username"];
}


if(isset($_GET["logout"]))
{
    $isloggingout = filter_var($_GET["logout"], FILTER_SANITIZE_STRING);
    if($isloggingout == 1) {
        session_destroy();
        header("Location: index.php");
    }
};

if(isset($_GET["success"]))
{
    echo '<h2 style="color:green"> Angebot erfolgreich erstellt </h2>';
    };
?>

<body> 

    <header> 
        <!--Hinzufügen selbst erstelltes Logo-->
        <img id="logo"src="./assets/img/logo2.png" alt="logo" >
        <h1 id="title">Wilkommen in der Filmfactory</h1> 
    
    
    <!--Hinzufügen Einloggen und Warenkorb Button-->
        <?php 
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
   
    
<!--Ende Navigationsmenü-->

<?php

    if(isset($_POST["submit"])){
        require("./phphelper/dbConnEstablisher.php");


        $movieNameOffered = $_POST["movieOffered"];
        $movieNameSearched = $_POST["movieSearched"];


        $searchedAmount = $_POST["searchedAmount"];
        $offeredAmount = $_POST["offeredAmount"];


        $statement = $db->prepare("SELECT userorders.*, products.name FROM userorders LEFT JOIN products ON products.id=userorders.productID WHERE userID='$username' AND products.name='$movieNameOffered'"); //check Username
        $statement->execute();
        $count = $statement->rowCount();
        $row = $statement->fetch();

        if($row["amount"] >= $offeredAmount)
        {

            $res = $db->query("SELECT products.id FROM products WHERE products.name='$movieNameSearched'")->fetch();
            $searchedMovieID = $res["id"];
            $offeredMovieID = $row["productID"];
            $newAmount = $row["amount"] - $offeredAmount;
            $db->query("UPDATE userorders SET amount=$newAmount WHERE userID='$username' AND productID=$offeredMovieID");
            $db->query("INSERT INTO `useroffers` (`userID`, `searchedMovieID`, `offeredMovieID`, `searchedAmount`, `offeredAmount`) VALUES ('$username', $searchedMovieID, $offeredMovieID, $searchedAmount, $offeredAmount)");
            header("Location: tradeOut.php?success");
        }
    }

?>




        
            <?php
            if(isset($_SESSION["username"]))
            {
                echo '<h1>Angebot erstellen</h1>';
                echo '<form action="tradeout.php" method="post">';

                $sql = "SELECT userorders.*, products.name, users.EMail FROM userorders LEFT JOIN products ON userorders.productID = products.id LEFT JOIN users ON users.EMail = userorders.userID WHERE userorders.userID='$username'";
                $result = $db->query($sql);

                echo "Ich gebe ";
                echo "<select name='movieOffered' style='color:black;' >";
                while ($row = $result->fetch()) {
                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                }
                echo '</select> x <input type="number" name="offeredAmount" class="btn-light" style="width:8vw" min="1" max="10" placeholder="Menge" required> <br>';

                echo "Ich tausche gegen ";

                $sql2 = "SELECT userorders.*, products.name FROM userorders LEFT JOIN products ON userorders.productID = products.id GROUP BY products.name";
                $result2 = $db->query($sql2);

                echo "<select name='movieSearched' style='color:black;' >";
                while ($row2 = $result2->fetch()) {
                    echo "<option value='" . $row2['name'] . "'>" . $row2['name'] . "</option>";
                }
                echo '</select> x <input type="number" name="searchedAmount" class="btn-light" style="width:8vw" min="1" max="10" placeholder="Menge" required> <br>';

                echo '<button type="submit" name="submit" class="btn btn-primary">Angebot erstellen</button> <br> </form>';
            }
            
            else {
                echo '<a href="http://localhost:8080/WebProgJava/register.jsp"> <h1> Du musst angemeldet sein, um Tickets tauschen zu können. Registriere dich hier!</h1></a>';
            }
                ?>
            
    
<br>





<!--Horizontale Linie mit Abstand-->
    <hr id="abstand_footer">
    <br>
    
    <div style="font:20px;text-align:center;text-indent:10p;"><b>Kontakt</b></div>
    <br>	
    <div style="font:14px;text-align:center;text-indent:10px;">Infoline: 467657667<br><br>Reservierungen:5765755<br><br>E-mail: reservierungen@filmfactory.com</div>
    <hr>
        <span style="font:14px ;text-align:middle;text-indent:10px;"><b>Filmfactory GmbH & Co. KG</b><br><br>Filmfactorystraße 1<br><br>68015 Mannheim</span><br><br>
        <span style="font:14px ;text-align:right;text-indent:10px;color:white;"><a href="anfahrt.html" style="text-decoration: underline;font: 14px;color:white">Für weitere Informationen klicken Sie hier.</a></span>
        <hr>
    

    <!-- Cookies-->
    <!--Banner zum Wegklicken-->
        <br><br><br>
        <div id="cookie" style="color:black;"><div>
            <span>Ja, auch diese Webseite verwendet Cookies. </span> 
            <!--Link zur Datenschutzerklärung-->
            <a href="datenschutz.php" style="text-decoration:underline">Hier erfahrt ihr alles zum Datenschutz. </a><br>Sehen Sie hier Cookies dieser Webseite ein: <p id="info"></p></div>
           <span id="cookieCloser" onclick="document.cookie = 'hidecookie=1;path=/';jQuery('#cookie').slideUp()">&#10006;</span>
          </div>
          
          <script>
           if(document.cookie.indexOf('hidecookie=1') != -1){
           jQuery('#cookie').hide();
           }
           else{
           jQuery('#cookie').prependTo('body');
           jQuery('#cookieCloser').show();
           }
          </script>

        <!--Einbindung JS Cookies Datei-->
        <script src="./assets/js/cookies.js"></script>
        
    <!-- Cookies Ende-->

    <!--Einbindung Panorama Canvas Java Skript Code-->
    <script src="./assets/js/canvas.js"></script>


    <script src="./assets/js/bootstrap.min.js"></script>
</body>
</html>

