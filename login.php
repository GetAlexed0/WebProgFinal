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
</header>


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

<div class="container">
<h1>Anmelden</h1>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="E-Mail" id="inputdefault" style="color:black; font-size:x-large" required><br>
            <input type="password" name="pw" placeholder="Passwort" style="color:black; font-size:x-large" required><br><br>
            <button type="submit" name="submit" class="btn btn-primary">Einloggen</button>
    </form>
<br>
<?php

    if(isset($_POST["submit"])){
        require("./phphelper/dbConnEstablisher.php");

        $statement = $db->prepare("SELECT * FROM users WHERE EMail= :user"); //check Username
        $statement->bindParam(":user", $_POST["username"]);
        $statement->execute();
        $count = $statement->rowCount();

        if($count != 0) {
            $row = $statement->fetch();
            if(password_verify($_POST["pw"], $row["Password"])) {
                session_start();
                $_SESSION["username"] = $row["EMail"];

                header("Location: index.php");
            }
        }

        else {
            echo "<h2 class>Login Fehlgeschlagen <br><h2>";
        }
    }

?>
    <a href="http://localhost:8080/WebProgJava/register.jsp" id="registernow"><u>Doch noch keinen Account erstellt? Registriere dich jetzt!</u></a>


</div>

    

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