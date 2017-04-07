<!DOCTYPE HTML> 
<html>
<head>
	<meta charset="utf-8">
	<title>wczytywanie programu zebrań</title>
	<style>
		.error {color: #FF0000;}
	</style>
</head>
<body> 

<?php
// define variables and set to empty values
$errProgramCaly = "";
$programCaly = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["programCaly"])) {
     $errProgramCaly = "należy wypełnić pole z programem";
   } else {
     $programCaly = test_input($_POST["programCaly"]);
   }
   
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<h2>Program zebrań w tygodniu</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Treść programu: <textarea name="comment" rows="5" cols="40"><?php echo $programCaly;?></textarea>
   <br><br>
   <input type="submit" name="submit" value="Submit"> 
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $programCaly;
?>
</body>
</html>