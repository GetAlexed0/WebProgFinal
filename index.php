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


<?php

session_start();
if(isset($_SESSION["username"]))
{
    $userName = $_SESSION["username"];
}


if(isset($_GET["logout"]))
{
    $isloggingout = filter_var($_GET["logout"], FILTER_SANITIZE_STRING);
    if($isloggingout == 1) {
        session_destroy();
        header("Location: index.php");
    }
};


if(isset($_GET["registration"]))
{
    $issucess = filter_var($_GET["registration"], FILTER_SANITIZE_STRING);
    if($issucess == "sucess") {
        echo '<script> alert("Registrierung erfolgreich! Melden Sie sich nun an"); </script>';
    }
};
?>
    <header> 
        <!--Hinzufügen selbst erstelltes Logo-->
        <img id="logo"src="./assets/img/logo2.png" alt="logo" >
        <h1 id="title">Wilkommen in der Filmfactory</h1> 
    
    
    <!--Hinzufügen Einloggen und Warenkorb Button-->
        <?php 
        if(isset($_SESSION["username"])) {
            echo '<a href="myAccount.php" class="btnanmelden"><i class="fa fa-user"></i>' . $_SESSION["username"] . '</a>';
            echo '<a href="index.php?logout=1" class="btn3"><i class="fa fa-user"></i> Logout</a>'; 
            echo '<a href="#" class="btn2"><i class="fa fa-shopping-basket"></i> Meine Tickets</a> ';
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

<!--Seitenüberschrift "Top Filme der Woche"-->
<h2 id="index_titel">Top Filme der Woche</h2>


<?php 

require("./phphelper/dbConnEstablisher.php");

for($i = 3; $i >=1; $i--) {
    
    $query= "SELECT * FROM products WHERE id=$i";
    $result = $db->query($query);
    $row = $result->fetch();

    //Filmcover im jpg-Format, linkszentriert-->
    echo '<br>
    <img class="cover" src="./assets/img/'. $row["img"] .'" align="left" alt="film1"/>
    <br/>';

    // Rechteckige Box mit Filminformationen und Kaufen-Button-->
    echo '<div class="filmbeschreibung"><b>' . $row["name"] . '</b><br><br>
    '.$row["desc"].'<br><br>Genre: '.$row["genre"].'<br><br>Dauer: '.$row["length"].'<br><br>FSK: '.$row["fsk"].'<a href="/webprog/confirmation.php?movieID='. $row["id"]. '" class="btnfilm1" style="float:right;"><i class="fa fa-shopping-basket"></i>Tickets sichern</a></div>';

            //Abstand
echo '<br class="clear"/>';

}



?>
    

<!--Weiterführender Link (SVG) zum kompletten Kinoprogramm-->
<p id="komplettes_kino">Sehen Sie unser komplettes Kinoprogramm ein:</p>

<!--Eigenerstellte SVG-Graphik: Link zum Kinoprogramm -->
<div class="grid">
    <svg id="svg" width="55" height="55" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
        <a xlink:href="programm.php">
        <polyline points="3 3 30 28 3 53"></polyline>
        </a>
    </svg>  
</div>

<br>
<!--Textüberschrift: Blick in die Filmfactory-->
<p id="panorama">Blick in die Filmfactory</p>

<!--Einfügen eines Panorama Canvas (width und height muss mit Canvas identisch sein)-->
<canvas id="canvas" width="1000" height="700"></canvas>

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

