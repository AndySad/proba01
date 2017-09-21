<?php
	require 'connect.php';
	include "LIB/zebranie.php";
	global $dbo;
	date_default_timezone_set("Europe/Warsaw");
	$okres="XX";
	$page = null;
	if(isset($_POST['okres'])){
	    $okres = $_POST['okres'];
	}
?>
<!DOCTYPE HTML> 
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $okres; ?> programu zebrań</title>
	<style>
		.error {color: #FF0000;}
	</style>
</head>
<body> 
	<h1>Plan Zebrań w Tygodniu</h1>
	<?php
		$okresy = $dbo->query("SELECT date_format(tydzien_od, '%Y-%m') as XX, count(*) as liczba_zebran FROM `tydzien` where tydzien_od > DATE_FORMAT(NOW() ,'%Y-%m-01') group by 1 order by 1"); // Run your query
	?>
	<form name="myform" action="" method="post">
		<select name="okres" onchange="this.form.submit()">
		<option value="XX">-- wybierz okres --</option>';
		<?php
		// Loop through the query results, outputing the options one by one
			while ($row = $okresy->fetch(PDO::FETCH_ASSOC)) {
				echo '<option value="'.$row['XX'].'" ';
				if($okres == $row['XX']){ echo " selected"; }
				echo '>'.$row['XX'].'</option>';
			}
		?>
		</select>
	</form>
<?php
	if(isset($_POST['okres'])){
	    $okres = $_POST['okres'];
	    $sql="SELECT * FROM `tydzien` where DATE_FORMAT(tydzien_od,'%Y-%m') = '$okres' order by tydzien_od";
	    $tygodnie = $dbo->query($sql); // Run your query
	    $ileTygodniNaKartke=2;
	    $licznikTygodni=0;
	    $stopka="";
	    while ($row = $tygodnie->fetch(PDO::FETCH_ASSOC)){
	    	$zebranie=new zebranie();
	    	$zebranie->get_tydzien_od_z_BAZY($row['id']);
	    	
	    	$licznikTygodni++;
	    	$stopka.=$licznikTygodni;
	    	if ($licznikTygodni%$ileTygodniNaKartke) {
	    		$stopka.=" i ";
	    	}
	    	printf("%s [%d]<br>",$row['tydzien_od'],$row['id']);
	    	//echo $row['tydzien_od']."<br />";
	    	if (!($licznikTygodni%$ileTygodniNaKartke)) {
	    		echo "tydzień $stopka<br />";
	    		$stopka="";
	    	}
	    }
	    if ($licznikTygodni==5){
	    	echo "tydzień 5<br />";
	    }
	}
?>	
</body>
</html>