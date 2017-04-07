<?php
$dbhost							= "localhost";
$dbuser							= "root";
$dbpass							= "andysad1";
$dbname							= "program";

try {
	$dbo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",
    $dbuser, $dbpass, array(
        	PDO::ATTR_EMULATE_PREPARES => false,
        	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    	)
	);
} catch (PDOException $e) {
	print "Połączenie nie mogło zostać utworzone.<br />: " . $e->getMessage() . "<br/>";
	die();
}


?>