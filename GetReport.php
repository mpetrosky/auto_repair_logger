<html><head><title>Auto Repair Report</title></head><body>
<?php
$db_host = 'localhost';
$database = 'autorepair';

if (!mysql_connect($db_host, $db_user, $db_pwd))
    die("Can't connect to database");

if (!mysql_select_db($database))
    die("Can't select database");

// sending query
function GetTable($query)
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
GetTable("select * from vehicle");
GetTable("select * from service");
GetTable("select * from stats");
mysql_free_result($result);
?>
</body></html>
