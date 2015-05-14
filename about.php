<?php
session_start();?>
<!DOCTYPE HTML><head><title>About Us</title><meta http-equiv="Content-Type" content="text/html" charset=ISO-8859-1"> </head><body>
<!--Создал Михаил Петровский-->
&#1057&#1086&#1079&#1076&#1072&#1083 &#1052&#1080&#1093&#1072&#1080&#1083 &#1055&#1077&#1090&#1088&#1086&#1074&#1089&#1082&#1080&#1081<br>
This website was created to digitally manage the maintenance logs of vehicles<br>
<a href=GetReport.php>Enter Maintenance Log</a> | <a href=CreateStats.php>Enter additional stats</a> | <a href=GetFullReport.php>View Full Report</a> | <a href=about.php>About Us</a> | <a href=index.php>Logout to Main Page</a>
<?php
#old code
/*function GetTable($query)
{
	$result = mysql_query($query);
	if(!$result)
	{
		die("Query failed");
	}

	$fields_num = mysql_num_fields($result);

	echo "<table border='1'><tr>";
	for($i=0; $i<$fields_num; $i++)
	{
		$field = mysql_fetch_field($result);
		echo "<td>{$field->name}</td>";
	}
	echo "</tr>";

	while($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		foreach($row as $cell)
		   echo "<td>$cell</td>";
		echo "</tr>";
	}
	echo "</table><br><br>";
}

/*for($i=mysql_num_rows($result); $i>mysql_num_rows($result)-5; $i--)
	{
		$row = mysql_fetch_row($result);
		echo "<tr>";
		foreach($row as $cell)
		   echo "<td>$cell</td>";
		echo "</tr>";
	}*/?>
</body></html>
