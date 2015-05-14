<?php
session_start();?>
<html><head><title>Create Statistic</title></head><body>
<?php
$db_host = 'localhost';
$database = 'autorepair';
$db_user = $_SESSION["username"];
$db_pwd = $_SESSION["password"];
if (!mysql_connect($db_host, $db_user, $db_pwd)) die("Can't connect to database");
if (!mysql_select_db($database)) die("Can't select database");
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
function FormSelection()
{
	if($_GET["FormType"]) echo "Choose another field<br>";
	echo "<form action='CreateStats.php' method='GET' target='_self'><select name='FormType'><option value=1>Vehicle</option><option value=2>Part</option><option value=3>Service</option><br><input type='submit' value='Select'></form>";
}
function CreateForm()
{
	switch ($_GET["FormType"])
	{
		case 1:
			CreateVehicle();
			break;
		case 2:
			CreatePart();
			break;
		case 3:
			CreateService();
			break;
		default:
			echo "Please make a selection";
			break;
	}
}
function CreateStat()
{
	#process POST data for SQL statement creation
	if($_POST["VIN"]) $result = mysql_query("insert into vehicle(vin,make,model,year,engine) values('".$_POST["VIN"]."','".$_POST["Make"]."','".$_POST["Model"]."','".$_POST["Year"]."','".$_POST["Engine"]."')");
	else if($_POST["PartName"]) $result = mysql_query("insert into parts(cost,part_name,part_number,store_bought) values('".$_POST["Cost"]."','".$_POST["PartName"]."','".$_POST["PartNumber"]."','".$_POST["StoreBought"]."')");
	else if($_POST["AddlCost"]) $result = mysql_query("insert into service(name,addl_cost,taken_to_shop,part_number,vID) values('".$_POST["Name"]."','".$_POST["AddlCost"]."','".$_POST["TakenToShop"]."','".$_POST["PartNumber"]."','".$_POST["VehicleID"]."')");
	else echo "return?";
	if(!$result) die("Insertion failed".mysql_error());
}
function CreateVehicle()
{
	#fields: vin,vID,make,model,year,engine
	echo "<form action='CreateStats.php' method='POST' target='_self'>Enter VIN: <input type='text' name='VIN'><br>Enter manufacturer: <input type='text' name='Make'><br>Enter model: <input type='text' name='Model'><br>Enter year: <input type='text' name='Year'><br>Enter engine: <input type='text' name='Engine'><br><input type='hidden' name='CreateEntry' value='1'><input type='submit' value='Add entry'></form>";
	if($_SESSION["username"]=="user") GetTable("select vID as 'Vehicle ID',vin as 'VIN',make as 'Manufacturer',model as 'Model',year as 'Year',engine as 'Engine' from vehicle");
	else GetTable("select vID as 'Vehicle ID',make as 'Manufacturer',model as 'Model',year as 'Year',engine as 'Engine' from vehicle");
}
function CreatePart()
{
	#fields: cost,part_name,part_number,store_bought
	echo "<form action='CreateStats.php' method='POST' target='_self'>Enter cost: <input type='text' name='Cost'><br>Enter part name: <input type='text' name='PartName'><br>Enter part number: <input type='text' name='PartNumber'><br>Enter the store that it was bought from: <input type='text' name='StoreBought'><br><input type='hidden' name='CreateEntry' value='1'><input type='submit' value='Add entry'></form>";
	GetTable("select cost as 'Cost',part_name as 'Part Name',part_number as 'Part Number',store_bought as 'Store Purchased' from parts");
}
function CreateService()
{
	#fields: sID,name,addl_cost,taken_to_shop,part_number,vID
	echo "<form action='CreateStats.php' method='POST' target='_self'>Enter name: <input type='text' name='Name'><br>Enter additional cost: <input type='text' name='AddlCost'><br>Taken to the shop(Y/N)?: <input type='text' name='TakenToShop'><br>Enter part number: <input type='text' name='PartNumber'><br>Enter vehicle ID: <input type='text' name='VehicleID'><br><input type='hidden' name='CreateEntry' value='1'><input type='submit' value='Add Entry'></form>";
	GetTable("select sID as 'Service ID',vID as 'Vehicle ID',name as 'Name',addl_cost as 'Additional Cost',taken_to_shop as 'Taken to Shop',part_number as 'Part Number' from service order by name,vID");
}
if($_POST["CreateEntry"]==1) CreateStat();
FormSelection();
if($_GET["FormType"]) CreateForm();
echo "<a href=GetReport.php>Enter Maintenance Log</a> | <a href=CreateStats.php>Enter additional stats</a> | <a href=GetFullReport.php>View Full Report</a> | <a href=about.php>About Us</a> | <a href=index.php>Logout to Main Page</a>";
?>
</body></html>
