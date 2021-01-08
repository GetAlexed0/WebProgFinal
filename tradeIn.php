<?php 

session_start();
require("./phphelper/dbConnEstablisher.php");

if(isset($_SESSION["username"]))
$username = $_SESSION["username"];
?>
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

if(isset($_GET["received"]))
{
    $decoded = urldecode($_GET['received']);
    echo '<h2 style="color:green"> Du hast die Tickets von <i>'.$decoded.' erhalten!</i><h2>';
}

if(isset($_GET["offerID"]))
{
    if(isset($_SESSION["username"]))
    {
    $currentOfferID = $_GET["offerID"];
    $offerQuery = "SELECT useroffers.*, users.FirstName, products.* FROM useroffers LEFT JOIN users ON useroffers.userID=users.EMail LEFT JOIN products ON products.id=useroffers.searchedMovieID WHERE useroffers.offerID = $currentOfferID";
    $offerResults = $db->query($offerQuery);
        if($row= $offerResults->fetch())
        {
            $offeredMovie = $row["offeredMovieID"];
            $currentMovie = $row["searchedMovieID"];
            $userOrders = $db->query("SELECT * FROM userorders WHERE userID='$username' AND productID=$currentMovie");
            $userOrders2 = $db->query("SELECT * FROM userorders WHERE userID='$username' AND productID=$offeredMovie");
            if($userOrderResult = $userOrders-> fetch())
            {
                if($userOrderResult["amount"] >= $row["searchedAmount"]) {
                    $userOrderResult2 = $userOrders2->fetch();

                    $newAmount = $userOrderResult["amount"] - $row["searchedAmount"];
                    $newAmount2 = $userOrderResult2["amount"] + $row["offeredAmount"];
                    $db->query("UPDATE userorders SET amount=$newAmount WHERE userID='$username' AND productID=$currentMovie");

                    $userAlreadyOwnedTicket = $db->query("SELECT * FROM userorders WHERE userID='$username' AND productID=$offeredMovie");
                    $offeredMovieName = $db->query("SELECT name FROM products WHERE id=$offeredMovie")->fetch();

                    //Füge Tickets zu anbietenden User hinzu
                    $offeringUser = $row["userID"];
                    $seekerAlreadyGotMovie = $db->query("SELECT * FROM userorders WHERE userID='$offeringUser' AND productID=$currentMovie");
                    $bla = $seekerAlreadyGotMovie->fetch();
                    $searchedAmount =$row["searchedAmount"];

                    if($bla)
                    {
                        
                        echo "<script> alert($searchedAmount) </script>";
                        $offerUserNewAmount = $bla["amount"] + $row["searchedAmount"];
                        echo "<script> alert($offerUserNewAmount) </script>";
                        $db->query("UPDATE userorders SET amount=$offerUserNewAmount WHERE userID='$offeringUser' AND productID=$currentMovie");
                    }

                    else
                    {
                        $db->query("INSERT INTO userorders (userID, productID, amount) VALUES ('$offeringUser', $currentMovie, $searchedAmount)");
                    }
                    
                    


                     if($userAlreadyOwnedTicket->rowCount())
                     {
                        $db->query("UPDATE userorders SET amount=$newAmount2 WHERE userID='$username' AND productID=$offeredMovie");
                        $db->query("DELETE FROM useroffers WHERE offerID=$currentOfferID");
                        header ("Location: tradeIn.php?received=".urldecode($offeredMovieName["name"]));
                    }

                 else {
                     $db->query("INSERT INTO userorders (userID, productID, amount) VALUES ('$username', $offeredMovie, $newAmount2);");
                     $db->query("DELETE FROM useroffers WHERE offerID=$currentOfferID");
                     header ("Location: tradeIn.php?received=".urldecode($offeredMovieName["name"]));
                 }
                    
                }
            }

            else {
                echo '<h2 style="color:red"> Du hast nicht genügend Tickets von: <i>'.$row["name"].'</i><h2>';
            }

        }
    }

    else {
        echo '<h1 href="http://localhost:8080/webprogjava/register.jsp/>> Du musst angemeldet sein, um Tickets reservieren zu können! Registriere dich hier</h1>';
    }
};
?>
<!--Seitenüberschrift "Top Filme der Woche"-->



<?php 
if(isset($_SESSION["username"]))
{
echo '<h2 id="index_titel">Tauschangebote</h2>';
require("./phphelper/dbConnEstablisher.php");
$query= "SELECT * FROM products";
$result = $db->query($query);

while($row = $result->fetch()) {

    //Filmcover im jpg-Format, linkszentriert-->
    echo '<br>
    <img class="cover" src="./assets/img/'. $row["img"] .'" align="left" alt="film1"/>
    <br/>';

    // Rechteckige Box mit Filminformationen und Kaufen-Button-->
    echo '<div class="filmbeschreibung"><b>' . $row["name"] . '</b><br><br>';

    $aktuelleID = $row["id"];
    $query2 = "SELECT useroffers.*, users.FirstName, products.name FROM useroffers LEFT JOIN users ON useroffers.userID=users.EMail LEFT JOIN products ON products.id=useroffers.searchedMovieID WHERE offeredMovieID= $aktuelleID  AND useroffers.userID <>'$username'";
    $result2 = $db->query($query2);

    $count = 1;
    while($row2 = $result2->fetch())
    {

        echo '<b>Angebot '.$count++.'</b>:<br>'.$row2["FirstName"].' bietet '.$row2["offeredAmount"].' Tickets im Tausch gegen '.$row2["searchedAmount"].' Tickets von '.$row2["name"].' <a href="/webprog/tradein.php?offerID='. $row2["offerID"]. '" class="btn-primary" style="float:right; margin-left: 1em;"><i class="fa fa-shopping-basket"></i>Tausch annehmen</a> <br><br>';
            //Abstand

    }

    echo'</div>';
    echo '<div class="clear"></div>';
}

echo '<div class="clear"></div>';
}
else {
    echo '<a href="http://localhost:8080/WebProgJava/register.jsp"> <h1> Du musst angemeldet sein, um Tickets tauschen zu können. Registriere dich hier!</h1></a>';
}

?>
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

    <script src="./assets/js/bootstrap.min.js"></script>
</body>
</html>

