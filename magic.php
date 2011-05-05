<?
// Data In
$res = json_decode($_REQUEST['data'], true);

// Downs Count
/*
for ($i = 1; $i <= $res["downs_count"]; $i = $i + 1) {
	echo '<img src="ui/images/Football-Ball-icon.png" width="20" height="20"/>&nbsp;&nbsp;&nbsp';
}
*/
$res["downs_count"] = '<img src="ui/images/Football-Ball-icon.png" width="20" height="20"/>&nbsp;&nbsp;&nbsp<img src="ui/images/Football-Ball-icon.png" width="20" height="20"/>&nbsp;&nbsp;&nbsp';


// Temas Count
// <li class="ui-state-default" style="width:225px;"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Team # Score #</li>
$res["sortable"] = 	'';

// Data Out
echo json_encode($res);
?>