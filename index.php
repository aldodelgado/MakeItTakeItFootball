<?php
/*
	Make-It Take-It Football by Aldo Delgado aldo@osstek.com

	Game Description:
		What does this app do? Well this is a widget for the feild game Make-It Take-It Football. This widget is to assist you with organizing and managing the teams and keep score of the game. To configure your widget please set the amount of teams you want to have play and the amounts of downs per game. 

	Game Rules:

	Game Setup: 
		1) Number of teams then loop through and give each team a name - 'There are 2 $vars here'
		2) Number of downs for each game - 'There is 1 $var'
		3) Number of seconds for each down - 'There is 1 $var'

	App Notes: 
		1) Setup should lock once start game has been pressed	
		2) When clock runs down, out-of-time a alarm sounds
		3) When touchdown is pressed it should ask who was the winner
		4)
 */
?>

<html>
<head>
	<title>Make-it Take-it Football Widget</title>

	<!-- Stylesheets -->
	<link rel="stylesheet" href="ui/css/main.css" type="text/css" media="all" />

	<style type="text/css">
		#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
		#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
		#sortable li span { position: absolute; margin-left: -1.3em; }
	</style>

	<style>
		#draggable { width: 100px; height: 100px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; }
		#droppable { width: 150px; height: 150px; padding: 0.5em; float: left; margin: 10px; }
	</style>	
	<!-- / Stylesheets -->

	<!-- Javascripts -->
	<script src="ui/js/jquery.min.js" type="text/javascript"></script>
	<script src="ui/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="ui/js/jquery.marquee.js" type="text/javascript"></script>		
	<script src="ui/js/jquery.json-2.2.js" type="text/javascript"></script>
	<script language="javascript">

		// Game configuration setup 
		var game_setup = function () {
			// Ask for how many teams are going to play?
			var teams_count = prompt("How many teams in this game?", "");				

			// Confirm if that was the correct amount of teams
			if (confirm("You have " + teams_count + " teams?")) {	

				// Loop through the amount the teams and create the sortables
				for (i=1;i i<=teams_count; i++) {
					$("#sortable").append('<li class="ui-state-default" style="width:225px;"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Team # Score #</li>');
				}		
						
				// Enter the names of the teams					
				var downs_count = prompt("How many downs in this game?", "");

				// Confirm the amount of downs
				if (confirm("You have " + downs_count + " downs?")) {
					
					// Loop through the amount of downs	and create the downs
					for(i=1;i <= downs_count;i++) {
						$("#downs_count").append('<img src="ui/images/Football-Ball-icon.png" width="20" height="20"/>&nbsp;&nbsp;&nbsp');
					}
				}		

				var data = new Object();
				data.teams_count = teams_count;
				data.downs_count = downs_count;
				var dataString = $.toJSON(data);
				
				$.post('magic.php', {data: dataString}, function(res) {
					var obj = $.evalJSON(res);	
					alert(obj.downs_count);
					//alert(obj.sortable);
					$("#downs_count").html(obj.downs_count);
					$("#sortable").html(obj.sortable);
					return true;
				});
			}
		}

		// Sortable
		$(function() {
			$( "#sortable" ).sortable();
			$( "#sortable" ).disableSelection();
		});

		// Draggable
		$(function() {
			$( "#draggable" ).draggable();
			$( "#droppable" ).droppable({
				drop: function( event, ui ) {
					$( this )
						.addClass( "ui-state-highlight" )
						.find( "p" )
						.html( "Dropped!" );
				}
			});
		});
	</script>
	<!-- / Javascripts -->
</head>
<body>

	<!-- Game Setup -->
	<input type="button" onclick="game_setup()" value="Configure Game">
	<!-- / Game Setup -->

	<!-- Game Board -->
	<form name="clockform">
		<table bgcolor="cornsilk" cellpadding="5" border="1" bordercolor="burlywood">
			<tr>
				<td>
					<table cellpadding="3" cellspacing="0" border="0" align="center">
						<tr>
							<td bgcolor="wheat">
								<input name="clock" value="00:00:00.00" style="text-align:center; width:174px; height:35px; font-size:24; font-weight:bold">
							</td>
						</tr>

						<tr>
							<td colspan="2" bgcolor="wheat">
								<input name="starter" type="button" value="Start" style="width:100px;" onclick="findTIME()">
									&nbsp;&nbsp;
								<input name="clearer" type="button" value="Reset" onclick="clearALL()">
								<br />
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td>
					<div style="text-align:center;width:280px;">
						<span style="padding:15px;">{Team}</span><b>VS</b><span style="padding:15px;">{Team}</span>

						<br />

						<hr style="width:75%" />

						<div style="font-weight:bold;text-align:center;">Current Down</div>
							<form name="downs_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

								<div id="downs_count" style="text-align:center;"></div>

								<hr style="width:90%;">

								<center>
									<input name="reset_down" type="button" value="Reset Down" >
										&nbsp;&nbsp;
									<input name="next_down" type="button" value="Next Down" >
										&nbsp;&nbsp;
									<input name="touchdown" type="button" value="Touchdown" >		
								</center>
							</form>
						</div>
					</div>
				</td>
			</tr>

			<tr>
				<td>
					<div style="text-align:center;">
						<!-- <marquee behavior="scroll" direction="left" scrollamount="4" width="270px"><p>Next {team} on deck!</p></marquee> -->
						<br />
						<span style="font-weight:bold;text-align:center;">Teams</span>
						<br />

						<div class="demo">
							<ul id="sortable">

							</ul>						
						</div>
					</div>
				</td>
			</tr>
		</table>
	</form>
	<!-- / Game Board -->
</body>
</html>
