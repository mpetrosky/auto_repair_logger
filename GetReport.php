<?php
session_start();?>
<html><head><title>Auto Repair Report</title></head><body>
<?php
$db_host = 'localhost';
$database = 'autorepair';
if($_POST["username"]) $_SESSION["username"] = $_POST["username"];
if($_POST["password"]) $_SESSION["password"] = $_POST["password"];
$db_user = $_SESSION["username"];
$db_pwd = $_SESSION["password"];
if (!mysql_connect($db_host, $db_user, $db_pwd)) die("Can't connect to database");
if (!mysql_select_db($database)) die("Can't select database");

// sending query
function GetTable($query)
{
	if($_POST["vehicleID"]) $query = $query." where stats.vID=".$_POST["vehicleID"]." order by stats.vID,mileage"; 
	$result = mysql_query($query);
	if(!$result) die("Query failed " . mysql_error());
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
		if($counter > (mysql_num_rows($result)-7))
		{
			echo "<tr>";
			foreach($row as $cell) echo "<td>$cell</td>";
			echo "</tr>";
		}
		$counter++;
	}
	/*for($i=mysql_num_rows($result); $i>mysql_num_rows($result)-5; $i--)
	{
		$row = mysql_fetch_row($result);
		echo "<tr>";
		foreach($row as $cell)
		   echo "<td>$cell</td>";
		echo "</tr>";
	}*/
	echo "</table><br><br>";
}
function CreateForm($query)
{
	$result = mysql_query($query);
	if(!result) die("Query failed");
	$counter = 1;
	while($row = mysql_fetch_row($result))
	{
		echo "<option value='$counter'>";
		foreach($row as $cell) echo $cell . " ";
		echo "</option>";
		$counter += 1;
	}
}
function CreateStat()
{
	$result = mysql_query("insert into stats(mileage,date_serviced,vID,sID) values('" . $_POST["mileage"]. "','" . $_POST["dateServiced"] . "','" . $_POST["vehicleID"] . "','" . $_POST["serviceID"] ."')");
	if(!$result) die("Insertion failed " . mysql_error());
}

if($_POST["dateServiced"]) CreateStat();
echo "<h3>Enter repair service data</h3><form action='GetReport.php' method='POST' target='_self'><select name='serviceID'>";
CreateForm("select name from service");
echo "</select><br><select name='vehicleID'>";
CreateForm("select year,make,model,engine from vehicle");
echo "</select><br>Enter mileage: <input type='text' name='mileage'><br>Enter date serviced (yyyy-mm-dd): <input type='date' name='dateServiced'><br><input type='submit' value='Submit'></form>";
GetTable("select stats.vID as 'Vehicle ID',mileage as Mileage,date_serviced as 'Date Serviced',name as 'Service Name',addl_cost as 'Additional Cost',taken_to_shop as 'Taken to Shop' from stats join service on (stats.sID=service.sID)");
#mysql_free_result($result);
echo "<a href=GetReport.php>Enter Maintenance Log</a> | <a href=CreateStats.php>Enter additional stats</a> | <a href=GetFullReport.php>View Full Report</a> | <a href=about.php>About Us</a> | <a href=index.php>Logout to Main Page</a>";
?>
</body></html>
