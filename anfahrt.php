<html lang="en"> 
<head>
    <title>Willkommen in der Filmfactory!</title> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Einbindung Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <!--Einbindung CSS-Stylesheet-->
    <link rel="stylesheet" href="./assets/css/test_stylesheet.css">
    <!--Einbindung Icon-Bibliothek-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Stylesheet für Smartphone Bildschirme-->
    <link rel="stylesheet" media="(max-width: 640px)" href="./assets/css/html5_stylesheet_mobile.css">
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

  <!--Navigationsmenü-->
    <nav>
        <ul>
          <br>
          <br>
            <li><a href="index.php">Startseite</a></li>
            <li><a href="programm.php">Programm</a>
            </li>
            <li tabindex="0"><a href="#">Tauschbörse</a>
            <ul class="submenu">
                    <li><a tabindex="0" href="tradeIn.php">Angebote</a>
                    </li>
                    <li><a tabindex="0" href="tradeOut.php">Angebot erstellen</a>
                    </li>
                </ul>
            
            <li tabindex="0" ,aria-current="page"><a href="anfahrt.php">Informationen</a>
           
            </li>
        </ul>
    </nav>


<div style="font-size:1.5em;text-align:left;text-indent:13em;float:left;">Öffnungszeiten</div> 
<div style="font-size:1.5em;float:left;text-indent: 1em">So-Do 10:00 - 01:00, Fr & Sa 10:00 - 02:00</div>

<div style="font-size:1.5em;text-align:left;text-indent:13em;margin-top:3em;">Eintrittspreise</div>
<!--Preistabelle-->
<center>
  <table>
    <caption scope="col">Eintrittspreise</caption><tr>
      <th scope="col">Zeiten</th>
      <th scope="col">Mo</th>
      <th scope="col">Di</th>
      <th scope="col">Mi</th>
      <th scope="col">Do</th>
      <th scope="col">Fr</th>
      <th scope="col">Sa</th>
      <th scope="col">So</th>
    </tr>
    <tr>
      <td >bis 12:00 Uhr</td>
      <td>7,00 €</td>
      <td>7,00 €</td>
      <td>7,00 €</td>
      <td>7,00 €</td>
      <td>7,00 €</td>
      <td>7,00 €</td>
      <td>7,00 €</td>
    </tr>
    <tr>
      <td>ab 12:00 Uhr</td>
      <td>7,00 €</td>
      <td>7,00 €</td>
      <td>8,00 €</td>
      <td>8,00 €</td>
      <td>9,50 €</td>
      <td>9,50 €</td>
      <td>9,50 €</td>
    </tr>
  </table>
</center>


<div style="font-size:1.5em;text-align:left;text-indent:13em;margin-top:3em;display:block;">Anfahrt zur Filfactory</div><br>
<!--Google Maps Karte-->
<iframe id="anfahrt" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3271.033929966783!2d8.532687438741496!3d49.47464118300759!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4797cf237f671903%3A0x58d1762d415c92ef!2sDuale%20Hochschule%20Baden-W%C3%BCrttemberg%20Mannheim!5e1!3m2!1sde!2sde!4v1607247064810!5m2!1sde!2sde" width="45%" height="40%" frameborder="0" style="border:1;margin-left:-7em" allowfullscreen="" aria-hidden="false" tabindex="0" ></iframe>

<hr>
<div style="font:20px;text-align:center;text-indent:10p;"><b>Kontakt</b></div>
<br>	
<div style="font:14px;text-align:center;text-indent:10px;">Infoline: 467657667<br><br>Reservierungen:5765755<br><br>E-mail: reservierungen@filmfactory.com</div>
<hr>
    <span style="font:14px ;text-align:middle;text-indent:10px;"><b>Filmfactory GmbH & Co. KG</b><br><br>Filmfactorystraße 1<br><br>68015 Mannheim</span><br><br>
    <span style="font:14px ;text-align:right;text-indent:10px;color:white;"><a href="anfahrt.html" style="text-decoration: underline;font: 14px;color:white">Für weitere Informationen klicken Sie hier.</a></span>
    <hr>
    
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>