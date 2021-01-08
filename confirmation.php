<?php 

session_start();
require("./phphelper/dbConnEstablisher.php");

if(isset($_SESSION["username"]))
$username = $_SESSION["username"];

$id = filter_var($_GET["movieID"], FILTER_SANITIZE_STRING);


$result = $db->query("SELECT * FROM products WHERE id=$id")->fetch();
$availableAmount = $result['available'];

$dataPoints = array( 

    array("label"=>"Verfügbar", "y"=> 0+ $availableAmount),
    array("label"=>"Reserviert", "y"=> 100 - $availableAmount)
)
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



    <script>
        window.onload = function() {
        
        var currentTime = new Date().toLocaleString();
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Verfügbare Tickets"
            },
            subtitles: [{
                text: currentTime
            }],
            data: [{
                type: "pie",
                yValueFormatString: "# Tickets",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
}
</script>
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
   
	<?php
$query = "SELECT * FROM products WHERE id=$id";

$result = $db->query("SELECT * FROM products WHERE id=$id");
$row = $result->fetch();
	
	echo '<img class="cover" src="./assets/img/'. $row["img"] .'" align="left" alt="film1"/><br>';
	

?>
<form action = "./confirmation.php?movieID=<?php echo $id; ?>" method="post">
<div class="filmbeschreibung">
	<input type="number" name="quantity" class="btn-light" style="width:6vw" min="1" max="10" placeholder="Menge">
	<input type="submit" name="submit" class="btn-light" value="Reservieren">
</div>
</form>

<?php 

	if(isset($_POST["submit"])){
        if(isset($_SESSION["username"]))
        {
        $amount = $_POST["quantity"];

        if($availableAmount >= $amount) //checkt ob genug Tickets frei sind
        {
            $statement = $db->prepare("SELECT * FROM userorders WHERE productID=$id AND userID='$username'");
            $statement->execute();
            $count = $statement->rowCount();
            $newavailable = $availableAmount - $amount;
            
            if($count == 0)
            {
                $db->query("INSERT INTO userorders (userID, productID, amount) VALUES ('$username', $id, $amount)");
                $db->query("UPDATE products SET available=$newavailable WHERE id=$id");
            }

            else {
            
                $row = $statement->fetch();
                $newAmount = $row["amount"] + $amount;
                if($newAmount < 10)
                {
                    $db->query("UPDATE userorders SET amount=$newAmount WHERE userID='$username' AND productID=$id");
                    $db->query("UPDATE products SET available=$newavailable WHERE productID=$id");  
                    header("Location: myAccount.php");
                }

                else {
                    echo '<p class="filmbeschreibung">Du hast entweder keine gültige Menge eingegeben oder bereits mehr als 10 Tickets reserviert</p>';
                }
            }
        }
        
        else {
            echo 'Es sind nicht mehr genügend Tickets vorhanden';
        }
    }
        
}


if(isset($_SESSION["username"]))
{
    echo '<div id="chartContainer" style="height: 370px; width: 50%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>';
}

else {
    echo '<a href="http://localhost:8080/WebProgJava/register.jsp"> <h1> Du musst angemeldet sein, um Tickets tauschen zu können. Registriere dich hier!</h1></a>';
}

?>
<div class="clear"></div>
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
    
                     


</body>
</html>