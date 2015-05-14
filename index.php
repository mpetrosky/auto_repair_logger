<?php
session_start();
session_unset();
session_destroy();
?>
<html><body><title>Automotive Repair Database</title>
<?php
/*
TODO
delete entries
*/
echo "<form action='GetReport.php' method='POST' target='_self'>Enter username: <input type='text' name='username' autofocus><br>Enter password: <input type='password' name='password'><br><input type='submit' value='Submit'></form>";
?>
</table>
</body>
</html> 
