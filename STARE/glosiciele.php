<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>głosiciele</title>
  <link rel="stylesheet" href="./style/bootstrap.min.css">
  <link rel="stylesheet" href="./style/style-jquery.css">
  <link rel="stylesheet" href="./style/jquery-ui.css">
  <script src="./skrypty/jquery-1.10.2.js"></script>
  <script src="./skrypty/jquery-ui-1.11.3.js"></script>
  <script src="./skrypty/bootstrap.min.js"></script>
  <style>
    body { font-size: 100%; }
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }

#grupa_0, #grupa_1, #grupa_2, #grupa_3, #grupa_4, #grupa_5, #grupa_6, #grupa_7, #grupa_8 {
    border: 1px solid #eee;
    width: 160px;
    min-height: 20px;
    list-style-type: none;
    margin: 0;
    padding: 5px 0 0 0;
    float: left;
    margin-right: 10px;
  }
  #grupa_0 li, #grupa_1 li, #grupa_2 li, #grupa_3 li, #grupa_4 li, #grupa_5 li, #grupa_6 li, #grupa_7 li, #grupa_8 li {
    margin: 0 5px 5px 5px;
    padding: 5px;
    font-size: 1.2em;
    width: 120px;
  }
  #grupa_d0, #grupa_d1, #grupa_d2, #grupa_d3, #grupa_d4, #grupa_d5, #grupa_d6, #grupa_d7, #grupa_d8 {
    border: 1px solid #eee;
    width: 160px;
    min-height: 20px;
    list-style-type: none;
    margin: 0;
    padding: 5px 0 0 0;
    float: left;
    margin-right: 10px;
  }
  .shut-up {
    float:left;
    display: inline-block;
    margin-top: 1em;
  }
  </style>
	<script>
		$(function() {
			function slideout(){
				setTimeout(function(){
					$("#response").slideUp("slow", function () {});
				}, 7000);
			}

			$("#response").hide();
			var oldList, newList, item;
			$( "#grupa_0, #grupa_1, #grupa_2, #grupa_3, #grupa_4, #grupa_5, #grupa_6, #grupa_7, #grupa_8" ).sortable({
				connectWith: ".connectedSortable",
				//handle : '.handle',
				start: function (event, ui) {
					item = ui.item;
					newList = oldList = ui.item.parent();
					},
				stop: function (event, ui) {
					console.log("Moved " + item.text() + " from " + oldList.attr('id') + " to " + newList.attr('id'));
					console.log("Moved " + item.attr('id').split("_")[1] + " from " + oldList.attr('id').split("_")[1] + " to " + newList.attr('id').split("_")[1]);

					},
				change: function (event, ui) {
					if (ui.sender) {
						newList = ui.placeholder.parent();
						}
					},
				update : function () {
					var order = $(this).sortable("serialize") + '&update=update' + '&grupa='+(this.id).split("_")[1];
					var order1 = 'gg='+item.attr('id').split("_")[1] + '&update=update' + '&skad='+oldList.attr('id').split("_")[1] + '&dokad='+newList.attr('id').split("_")[1];
					console.info(order1);
					/*
					$.post("glosicieleUpdateList.php", order, function(theResponse){
						$("#response").html(theResponse);
						$("#response").slideDown('slow');
						slideout();
					});
					*/
					$.post("glosicieleUpdateList2.php", order1, function(theResponse){
						$("#response").html(theResponse);
						$("#response").slideDown('slow');
						//slideout();
					});
					
					//console.log(order);
					console.log(this.id);
					}
			}).disableSelection();
			
			var zmOpis="liczba: ";
			$( "span#grupa_d1" ).text(zmOpis + $("ul#grupa_1").find("li").length);
			$( "span#grupa_d2" ).text(zmOpis + $("ul#grupa_2").find("li").length);
			$( "span#grupa_d3" ).text(zmOpis + $("ul#grupa_3").find("li").length);
			$( "span#grupa_d4" ).text(zmOpis + $("ul#grupa_4").find("li").length);
			$( "span#grupa_d5" ).text(zmOpis + $("ul#grupa_5").find("li").length);
			$( "span#grupa_d6" ).text(zmOpis + $("ul#grupa_6").find("li").length);



//obsługa dodawania głosiciela
			
		});
	</script>
</head>
<body>
<!-- Modal -->
<div id="container">
	<div id="list">
		<div id="response"></div>
		<?php
                include("connect.php");
                $style=[
                		"ui-state-default",
                		"ui-state-hover",
                		"ui-state-focus",
                		"ui-state-active",
                		"ui-state-highlight",
                		"ui-state-error",
                		"ui-state-disabled"
                ];
                $kolory=[
                		"#F5F6CE",
                		"#F6E3CE",
                		"#F6CECE",
                		"#A9BCF5",
                		"#CEF6D8",
                		"#E0E0F8",
                		"#F6CEF5",
                		"#F5A9F2",
                		"#A9F5F2",
                		"#D358F7"
                ];
				$query  = "select id, nazwa from (
							SELECT 'głosiciel' nazwa,1 id union
							SELECT 'starszy',2 union
							SELECT 'sługa pomocniczy',3 union
							SELECT 'pionier stały',4 union
							SELECT 'głosiciel nieczynny',5 union
  		                    SELECT 'mieszkanie na zbiórki',6
  		                   ) as x
  		        ";
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$grId = stripslashes($row['id']);
					$grNaz = stripslashes($row['nazwa']);
					switch ($grId) {
						case 1:
							$select="SELECT g.id
  		                                   ,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
                                       FROM glosiciels g
                                      WHERE czy_pionier = 0 and czy_nieczynny = 0
                                      ORDER BY g.nazwisko, g.imie
                                     ";
							break;
						case 2:
							$select="SELECT g.id
  		                                   ,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
                                       FROM glosiciels g
                                      WHERE czy_starszy = 1
                                      ORDER BY g.nazwisko, g.imie
                                     ";
							break;
						case 3:
							$select="SELECT g.id
  		                                   ,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
                                       FROM glosiciels g
                                      WHERE czy_sluga = 1
                                      ORDER BY g.nazwisko, g.imie
                                     ";
							break;
						case 4:
							$select="SELECT g.id
  		                                   ,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
                                       FROM glosiciels g
                                      WHERE czy_pionier = 1
                                      ORDER BY g.nazwisko, g.imie
                                     ";
							break;
						case 5:
							$select="SELECT g.id
  		                                   ,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
                                       FROM glosiciels g
                                      WHERE czy_nieczynny = 1
                                      ORDER BY g.nazwisko, g.imie
                                     ";
							break;
						case 6:
							$select="SELECT g.id
  		                                   ,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
                                       FROM glosiciels g
                                      WHERE czy_zbiorki = 1
                                      ORDER BY g.nazwisko, g.imie
                                     ";
							break;
									
					}
					switch ($grId) {
						case 1:
							$klasa=$style[5];
							break;
						default:
							$klasa=$style[0];
							break;
					}
					echo "\n\t\t<div id=\"grupa_d".$grId."\" class=\"$klasa\">\n\t\t\t$grNaz<span id=\"grupa_d".$grId."\"></span>";
					echo "\n\t\t\t<ul id=\"grupa_".$grId."\" class=\"connectedSortable\">";
					
					$listGlosicieli = mysql_query($select);
					while($glosiciel = mysql_fetch_array($listGlosicieli, MYSQL_ASSOC))
					{
						$glId = stripslashes($glosiciel['id']);
						$glNaz = stripslashes($glosiciel['glosiciel']);
						echo "\n\t\t\t\t<li class=\"$klasa\" id=\"gg_$glId\" style=\"background-color:$kolory[$grId];width:140px;\"> $glNaz</li>";
					}
					echo "\n\t\t\t</ul>";
					echo "\n\t\t</div>";
				}
		?>
	</div>
</div>
</body>
</html>