<?php //grupy jako kontenery na listy g�osicieli ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>grupy | JQuery Drag and Drop Demo</title>
<link href="./style/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./skrypty/jquery.js"></script>
<script type="text/javascript" src="./skrypty/jquery-ui.js"></script>
<style>
ul {
	padding:0px;
	margin: 0px;
}
#response {
	padding:10px;
	background-color:#9F9;
	border:2px solid #396;
	margin-bottom:20px;
}
#list li {
	margin: 0 0 3px;
	padding:8px;
	background-color:#333;
	color:#fff;
	list-style: none;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	function slideout(){
		setTimeout(function(){
			$("#response").slideUp("slow", function () {});
		}, 2000);
	}

	$("#response").hide();
	$(function() {
		$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&update=update';
			$.post("updateList.php", order, function(theResponse){
				$("#response").html(theResponse);
				$("#response").slideDown('slow');
				slideout();
			});
		}});
	});
});	
</script>
</head>
<body>
<div id="container">
  <div id="list">

    <div id="response"> </div>
    <ul>
      <?php
                include("connect.php");
				$query  = "SELECT id, nazwa FROM grupas ORDER BY id ASC";
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$id = stripslashes($row['id']);
					$text = stripslashes($row['nazwa']);
	
					echo "<li id=\"arrayorder_\"".$id."\">".$text;
					echo "  <div class=\"clear\"></div>";
					echo "</li>";
				} ?>
    </ul>
  </div>
</div>
</body>
</html>
