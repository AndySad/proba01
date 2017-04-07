<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>układ grup 2015-06</title>
  <link rel="stylesheet" href="./style/jquery-ui.css">
  <script src="./skrypty/jquery-1.10.2.js"></script>
  <script src="./skrypty/jquery-ui-1.11.4.js"></script>
  <link rel="stylesheet" href="./style/style-jquery.css">
  <style>
  #grupa_0, #grupa_1, #grupa_2, #grupa_3, #grupa_4, #grupa_5, #grupa_6, #grupa_7, #grupa_8 {
    border: 1px solid #eee;
    width: 142px;
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
    width: 142px;
    min-height: 20px;
    list-style-type: none;
    margin: 0;
    padding: 5px 0 0 0;
    float: left;
    margin-right: 10px;
  }
  </style>
	<script>
		$(function() {
			function slideout(){
				setTimeout(function(){
					$("#response").slideUp("slow", function () {});
				}, 2000);
			}

			$("#response").hide();
			
			$( "#grupa_0, #grupa_1, #grupa_2, #grupa_3, #grupa_4, #grupa_5, #grupa_6, #grupa_7, #grupa_8" ).sortable({
				connectWith: ".connectedSortable",
				//handle : '.handle',
				update : function () {
					var order = $(this).sortable("serialize") + '&update=update' + '&grupa='+(this.id).split("_")[1];

					$.post("grupyUpdateList.php", order, function(theResponse){
						$("#response").html(theResponse);
						$("#response").slideDown('slow');
						slideout();
					});

					//console.log(order);
				}
			}).disableSelection();

			var zmOpis="liczba głosicieli: ";
			$( "span#grupa_d0" ).text(zmOpis + $("ul#grupa_0").find("li").length);
			$( "span#grupa_d1" ).text(zmOpis + $("ul#grupa_1").find("li").length);
			$( "span#grupa_d2" ).text(zmOpis + $("ul#grupa_2").find("li").length);
			$( "span#grupa_d3" ).text(zmOpis + $("ul#grupa_3").find("li").length);
			$( "span#grupa_d4" ).text(zmOpis + $("ul#grupa_4").find("li").length);
			$( "span#grupa_d5" ).text(zmOpis + $("ul#grupa_5").find("li").length);
			$( "span#grupa_d6" ).text(zmOpis + $("ul#grupa_6").find("li").length);
			$( "span#grupa_d7" ).text(zmOpis + $("ul#grupa_7").find("li").length);
			zmOpis="<br>liczba czynnych głosicieli: ";
			$( "span#grupa_d0" ).append(zmOpis + ($("ul#grupa_0").find("li").length-$("ul#grupa_0").find("li[czyNieczynny='1']").length));
			$( "span#grupa_d1" ).append(zmOpis + ($("ul#grupa_1").find("li").length-$("ul#grupa_1").find("li[czyNieczynny='1']").length));
			$( "span#grupa_d2" ).append(zmOpis + ($("ul#grupa_2").find("li").length-$("ul#grupa_2").find("li[czyNieczynny='1']").length));
			$( "span#grupa_d3" ).append(zmOpis + ($("ul#grupa_3").find("li").length-$("ul#grupa_3").find("li[czyNieczynny='1']").length));
			$( "span#grupa_d4" ).append(zmOpis + ($("ul#grupa_4").find("li").length-$("ul#grupa_4").find("li[czyNieczynny='1']").length));
			$( "span#grupa_d5" ).append(zmOpis + ($("ul#grupa_5").find("li").length-$("ul#grupa_5").find("li[czyNieczynny='1']").length));
			$( "span#grupa_d6" ).append(zmOpis + ($("ul#grupa_6").find("li").length-$("ul#grupa_6").find("li[czyNieczynny='1']").length));
			$( "span#grupa_d7" ).append(zmOpis + ($("ul#grupa_7").find("li").length-$("ul#grupa_7").find("li[czyNieczynny='1']").length));
			zmOpis="<br>liczba miejsc zbiórek: ";
			$( "span#grupa_d0" ).append(zmOpis + $("ul#grupa_0").find("li[czyZbiorki='1']").length);
			$( "span#grupa_d1" ).append(zmOpis + $("ul#grupa_1").find("li[czyZbiorki='1']").length);
			$( "span#grupa_d2" ).append(zmOpis + $("ul#grupa_2").find("li[czyZbiorki='1']").length);
			$( "span#grupa_d3" ).append(zmOpis + $("ul#grupa_3").find("li[czyZbiorki='1']").length);
			$( "span#grupa_d4" ).append(zmOpis + $("ul#grupa_4").find("li[czyZbiorki='1']").length);
			$( "span#grupa_d5" ).append(zmOpis + $("ul#grupa_5").find("li[czyZbiorki='1']").length);
			$( "span#grupa_d6" ).append(zmOpis + $("ul#grupa_6").find("li[czyZbiorki='1']").length);
			$( "span#grupa_d7" ).append(zmOpis + $("ul#grupa_7").find("li[czyZbiorki='1']").length);
			zmOpis="<br>liczba starszych: ";
			$( "span#grupa_d0" ).append(zmOpis + $("ul#grupa_0").find("li[czyStarszy='1']").length);
			$( "span#grupa_d1" ).append(zmOpis + $("ul#grupa_1").find("li[czyStarszy='1']").length);
			$( "span#grupa_d2" ).append(zmOpis + $("ul#grupa_2").find("li[czyStarszy='1']").length);
			$( "span#grupa_d3" ).append(zmOpis + $("ul#grupa_3").find("li[czyStarszy='1']").length);
			$( "span#grupa_d4" ).append(zmOpis + $("ul#grupa_4").find("li[czyStarszy='1']").length);
			$( "span#grupa_d5" ).append(zmOpis + $("ul#grupa_5").find("li[czyStarszy='1']").length);
			$( "span#grupa_d6" ).append(zmOpis + $("ul#grupa_6").find("li[czyStarszy='1']").length);
			$( "span#grupa_d7" ).append(zmOpis + $("ul#grupa_7").find("li[czyStarszy='1']").length);
			zmOpis="<br>liczba sług pomocniczych: ";
			$( "span#grupa_d0" ).append(zmOpis + $("ul#grupa_0").find("li[czySluga='1']").length);
			$( "span#grupa_d1" ).append(zmOpis + $("ul#grupa_1").find("li[czySluga='1']").length);
			$( "span#grupa_d2" ).append(zmOpis + $("ul#grupa_2").find("li[czySluga='1']").length);
			$( "span#grupa_d3" ).append(zmOpis + $("ul#grupa_3").find("li[czySluga='1']").length);
			$( "span#grupa_d4" ).append(zmOpis + $("ul#grupa_4").find("li[czySluga='1']").length);
			$( "span#grupa_d5" ).append(zmOpis + $("ul#grupa_5").find("li[czySluga='1']").length);
			$( "span#grupa_d6" ).append(zmOpis + $("ul#grupa_6").find("li[czySluga='1']").length);
			$( "span#grupa_d7" ).append(zmOpis + $("ul#grupa_7").find("li[czySluga='1']").length);

			$( "li[czyStarszy='1']" ).css( "color", "red" ).css( "font-weight", "bold" ).css( "font-style", "italic" );
			$( "li[czySluga='1']" ).css( "color", "blue" ).css( "font-weight", "bold" ).css( "font-style", "italic" );
			$( "li[czyNieczynny='1']" ).addClass("ui-state-disabled");
			
		});
	</script>
</head>
<body>
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
				$query  = "SELECT id, nazwa FROM grupas ORDER BY id ASC";
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$grId = stripslashes($row['id']);
					$grNaz = stripslashes($row['nazwa']);
					switch ($grId) {
						case 0:
							$select="SELECT g.id
  		                                   ,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
  		                                   ,IFNULL( gg.pozycja, 0 ) pozycja_id
    		                               ,czy_starszy
							               ,czy_sluga
							               ,czy_pionier
							               ,czy_zbiorki
    		                               ,czy_nieczynny
                                       FROM glosiciels g
                                            LEFT OUTER JOIN glosiciel_grupa gg ON g.id = gg.glosiciel_id
                                      WHERE gg.grupa_id IS NULL
  		                                 OR gg.grupa_id =0
                                      ORDER BY gg.grupa_id, gg.pozycja, g.nazwisko, g.imie
                                     ";
							break;
						default:
							$select="SELECT g.id
  		                                   ,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
  		                                   ,IFNULL( gg.pozycja, 0 ) pozycja_id
                                           ,czy_starszy
							               ,czy_sluga
							               ,czy_pionier
							               ,czy_zbiorki 
    		                               ,czy_nieczynny
							               FROM glosiciels g
                                            LEFT OUTER JOIN glosiciel_grupa gg ON g.id = gg.glosiciel_id
                                      WHERE gg.grupa_id = $grId
                                      ORDER BY gg.grupa_id, gg.pozycja, g.nazwisko, g.imie
                                     ";
							$select="SELECT g.id
											,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
											,IFNULL( gg.pozycja, 0 ) pozycja_id
											,czy_starszy
											,czy_sluga
											,czy_pionier
											,czy_zbiorki
											,czy_nieczynny
										FROM glosiciels g
										LEFT OUTER JOIN glosiciel_grupa gg ON g.id = gg.glosiciel_id
										WHERE gg.grupa_id = $grId and gg.pozycja = 1
										union
										select * from (
											SELECT g.id
													,CONCAT( g.nazwisko,  \" \", g.imie ) glosiciel
													,IFNULL( gg.pozycja, 0 ) pozycja_id
													,czy_starszy
													,czy_sluga
													,czy_pionier
													,czy_zbiorki
													,czy_nieczynny
												FROM glosiciels g
												LEFT OUTER JOIN glosiciel_grupa gg ON g.id = gg.glosiciel_id
												WHERE gg.grupa_id = $grId and gg.pozycja > 1
												ORDER BY gg.grupa_id, g.nazwisko, g.imie
										) as xx
								";
								
							break;
					}
					switch ($grId) {
						case 0:
							$klasa=$style[5];
							break;
						case 99:
							$klasa=$style[3];
							break;
						default:
							$klasa=$style[0];
							break;
					}
					echo "\n\t\t<div id=\"grupa_d".$grId."\" class=\"$klasa\">".
					     "\n\t\t\t<h3>$grNaz</h3><span id=\"grupa_d".$grId."\"></span>";
					echo "\n\t\t\t<ul id=\"grupa_".$grId."\" class=\"connectedSortable\">";
					
					$listGlosicieli = mysql_query($select);
					while($glosiciel = mysql_fetch_array($listGlosicieli, MYSQL_ASSOC))
					{
						$glId = stripslashes($glosiciel['id']);
						$glNaz = stripslashes($glosiciel['glosiciel']);
						$glPoz = stripslashes($glosiciel['pozycja_id']);
						$czySt = stripslashes($glosiciel['czy_starszy']);
						$czySl = stripslashes($glosiciel['czy_sluga']);
						$czyPi = stripslashes($glosiciel['czy_pionier']);
						$czyZb = stripslashes($glosiciel['czy_zbiorki']);
						$czyNi = stripslashes($glosiciel['czy_nieczynny']);
						echo "\n\t\t\t\t<li class=\"$klasa\" id=\"gg_$glId\" czyStarszy=\"$czySt\" czySluga=\"$czySl\" czyPionier=\"$czyPi\" czyZbiorki=\"$czyZb\" czyNieczynny=\"$czyNi\" style=\"background-color:$kolory[$grId]\">".($grId==0 ? "" : ""/*$glPoz*/)." $glNaz</li>";
					}
					echo "\n\t\t\t</ul>";
					echo "\n\t\t</div>";
				}
		?>
		
	</div>
</div>
</body>
</html>