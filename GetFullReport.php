<?php
session_start();?>
<html><head><title>Auto Repair Report</title></head><body>
<?php
$db_host = 'localhost';
$database = 'autorepair';
#if($_POST["username"]) $_SESSION["username"] = $_POST["username"];
#if($_POST["password"]) $_SESSION["password"] = $_POST["password"];
$db_user = $_SESSION["username"];
$db_pwd = $_SESSION["password"];

if (!mysql_connect($db_host, $db_user, $db_pwd)) die("Can't connect to database");
if (!mysql_select_db($database)) die("Can't select database");

// sending query
function GetTable($query)
{
	$result = mysql_query($query);
	if(!$result) die("Query failed ".mysql_error());
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
		foreach($row as $cell) echo "<td>$cell</td>";
		echo "</tr>";
	}
	echo "</table><br><br>";
}
function CreateForm()
{
	switch ($_GET["FormType"])
	{
		case 1:
			if($_SESSION["username"]=="user") GetTable("select vID as 'Vehicle ID',vin as 'VIN',make as 'Manufacturer',model as 'Model',year as 'Year',engine as 'Engine' from vehicle");
			else GetTable("select vID as 'Vehicle ID',make as 'Manufacturer',model as 'Model',year as 'Year',engine as 'Engine' from vehicle");
			break;
		case 2:
			GetTable("select cost as 'Cost',part_name as 'Part Name',part_number as 'Part Number',store_bought as 'Store Purchased' from parts");
			break;
		case 3:
			GetTable("select sID as 'Service ID',vID as 'Vehicle ID',name as 'Name',addl_cost as 'Additional Cost',taken_to_shop as 'Taken to Shop',part_number as 'Part Number' from service order by name,vID");
			break;
		case 4:
			GetTable("select stats.vID as 'Vehicle ID',mileage as Mileage,date_serviced as 'Date Serviced',name as 'Service Name',addl_cost as 'Additional Cost',taken_to_shop as 'Taken to Shop' from stats join service on (stats.sID=service.sID) order by stats.vID,mileage");
			break;
		default:
			echo "Please make a selection";
			break;
	}
}
function FormSelection()
{
	echo "<form action='GetFullReport.php' method='GET' target='_self'><select name='FormType'><option value=1>Vehicle</option><option value=2>Part</option><option value=3>Service</option><br><option value=4>Logs</option><br><input type='submit' value='Select'></form>";
}
/*
function CreateForm($query)
{
	$result = mysql_query($query);
	if(!result) die("Query failed");
	$counter = 1;
	while($row = mysql_fetch_row($result))
	{
		echo "<option value='$counter'>";
		foreach($row as $cell)
		    echo $cell . " ";
		echo "</option>";
		$counter += 1;
	}
}

function CreateStat()
{
	$query = "insert into stats(mileage,date_serviced,vID,sID) values('" . $_POST["mileage"]. "','" . $_POST["dateServiced"] . "','" . $_POST["vehicleID"] . "','" . $_POST["serviceID"] ."')";
	$result = mysql_query($query);
	if(!$result) die("Insertion failed" . mysql_error());
	#echo "Insert successful!<br>";
}*/
FormSelection();
if($_GET["FormType"]) CreateForm();

#mysql_free_result($result);
echo "<a href=GetReport.php>Enter Maintenance Log</a> | <a href=CreateStats.php>Enter additional stats</a> | <a href=GetFullReport.php>View Full Report</a> | <a href=about.php>About Us</a> | <a href=index.php>Logout to Main Page</a>";
?>
</body></html>
