<html><head><title>Create Statistic</title></head><body>
<?php
$db_host = 'localhost';
$database = 'autorepair';

if (!mysql_connect($db_host, $db_user, $db_pwd))
    die("Can't connect to database");

if (!mysql_select_db($database))
    die("Can't select database");

function CreateStat($query)
{
	$result = mysql_query($query);
	if(!$result) { die "Could not complete query";}
	
