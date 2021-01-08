<!DOCTYPE html>
<html lang="de"> 
<head>
    <title>Willkommen in der Filmfactory!</title> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/test_stylesheet.css">
    
    <!-- Einbindung Stylesheet für Smartphone-Bildschirme-->
    <link rel="stylesheet" media="(max-width: 640px)" href="./assets/css/html5_stylesheet_mobile.css">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    </style>
        <!-- Add icon library -->
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
   
    <nav>
        <ul>
          <br>
          <br>
            <li><a href="index.php">Startseite</a></li>
            <li aria-current="page"><a href="programm.php">Programm</a>
            </li>
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
    

    <h2 style="text-align:left; margin-left:10em;color:white">Aktuelle Filme</h2>
    <br/>
    
    
    <?php 

require("./phphelper/dbConnEstablisher.php");

    $query= "SELECT * FROM products";
    $result = $db->query($query);
    while($row = $result->fetch())
    {

    //Filmcover im jpg-Format, linkszentriert-->
    echo '<br>
    <img class="cover" src="./assets/img/'. $row["img"] .'" align="left" alt="film1"/>
    <br/>';

    // Rechteckige Box mit Filminformationen und Kaufen-Button-->
    echo '<div class="filmbeschreibung"><b>' . $row["name"] . '</b><br><br>
   '.$row["desc"].'<br><br>Genre: '.$row["genre"].'<br><br>Dauer: '.$row["length"].'<br><br>FSK: '.$row["fsk"].'<a href="/webprog/confirmation.php?movieID='. $row["id"]. '" class="btnfilm1" style="float:right;"><i class="fa fa-shopping-basket"></i>Tickets sichern</a></div>';

            //Abstand
echo '<br class="clear" />';
}

?>
    
        <hr style="margin-top: 35em;">
        <br>
        
      
<div style="font:20px;text-align:center;text-indent:10p;"><b>Kontakt</b></div>
<br>	
<div style="font:14px;text-align:center;text-indent:10px;">Infoline: 467657667<br><br>Reservierungen:5765755<br><br>E-mail: reservierungen@filmfactory.com</div>
<hr>
    <span style="font:14px ;text-align:middle;text-indent:10px;"><b>Filmfactory GmbH & Co. KG</b><br><br>Filmfactorystraße 1<br><br>68015 Mannheim</span><br><br>
    <span style="font:14px ;text-align:right;text-indent:10px;color:white;"><a href="anfahrt.html" style="text-decoration: underline;font: 14px;color:white">Für weitere Informationen klicken Sie hier.</a></span>
    <hr>



  

    <!-- Cookies-->
        
        <br><br><br>
        <div id="cookie" style="color:black"><div>
            <span>Ja, auch diese Webseite verwendet Cookies. </span> 
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

        
        <script src="./assets/js/cookies.js"></script>
        
    <!-- Cookies-->

      
        <script src="./assets/js/bootstrap.min.js"></script>
</body>
</html>

