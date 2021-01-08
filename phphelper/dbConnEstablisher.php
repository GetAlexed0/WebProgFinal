<?php

$host="localhost";
$name="sqluser";
$user="sqluser";
$pw ="123";

try {
    $db = new PDO("mysql:host=$host;dbname=$name", $user, $pw);
}

catch (PDOException $e) {
    echo "SQL Error: ".$e->getMessage();
}

?>