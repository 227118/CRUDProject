<?php
echo "<link href='dogLog.css' rel='stylesheet' type='text/css'>";
echo "<body>";

/* 
This block allows our program to access the MySQL database.
Elaborated on in 2.2.3.
 */
require_once '../login.php';
$db_server = mysql_connect($host, $username, $password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db('dog_activity_log')
	or die("Unable to select database: " . mysql_error());

echo '<a href="https://samyuravikumar-hour6-csp-samyuravikumar.c9users.io/Dog%20Activity%20Log/homePage.php">Back</a> <br>';


echo "<p>Dog Activity Log</p>";

// Allows user to CREATE data
echo <<<_END
<div>
<form action ="exerciseLog.php" method="post"><pre>
Type of Exercise: <input type="text" name="typeOfExercise" />
Amount of Time: <input type="text" name="amountOfTimeExercised" />
Time: <input type="text" name="timeExercised" />
Date: <input type="text" name="dateExercised" />	
Notes: <input type="text" name="exerciseNotes" />	
<div>
<input type="submit" value="ADD" />
</div>
</pre></form>
</div>
_END;



if (isset($_POST['typeOfExercise']) &&
	isset($_POST['amountOfTimeExercised']) &&
	isset($_POST['timeExercised']) &&
	isset($_POST['dateExercised']))
{
	// The get_post function is defined below to collect data from the POST protocol.
	$typeOfExercise = get_post('typeOfExercise');
	$amountOfTimeExercised = get_post('amountOfTimeExercised');
	$timeExercised = get_post('timeExercised');
	$dateExercised = get_post('dateExercised');
	$exerciseNotes = get_post('exerciseNotes');
	
	// This conditional block creates the new account in the database if possible
	$query = "INSERT INTO exercise VALUES" .
	"('$typeOfExercise','$amountOfTimeExercised', '$timeExercised', '$dateExercised', '$exerciseNotes')";
	
	if (!mysql_query($query, $db_server))
	{
    	echo "INSERT failed: $query<br/>" .
		mysql_error() . "<br /><br />";
	}
	else
	{
		echo "<script type = 'text/javascript'> alert('Entry successfully added!'); </script>";
	}
}

/** 
 * Quality of life function to reduce the amount of code needed to retrieve POST data
 * 
 * @param string $var the name of the element in the POST array to retrieve
 * @return string
 */
function get_post($var)
{
	return mysql_real_escape_string($_POST[$var]);
}

//Allows user to READ data
$result = mysql_query("SELECT * FROM exercise", $db_server);

echo "<table border='1'>
<tr>
<th>Type of Exercise</th>
<th>Amount of Time</th>
<th>Time</th>
<th>Date</th>
<th>Notes</th>
<th>Delete</th>
<th>Update</th>
</tr>";

$buttonIdentifier = 0;

echo "<form action='' method='get'";
while($row = mysql_fetch_array($result))
{
$buttonIdentifier = $buttonIdentifier + 1;

echo "<tr>";
echo "<td>" . $row['typeOfExercise'] . "</td>";
echo "<td>" . $row['timeDone'] . "</td>";
echo "<td>" . $row['amountOfTimeExercised'] . "</td>";
echo "<td>" . $row['dateExercised'] . "</td>";
echo "<td>" . $row['notes'] . "</td>";
echo "<td> <input type='submit' class='button' name='Delete' value='Delete'></input> </td>";
echo "<td> <input type='submit' class='button' name='Update' value='Update'></input> </td>";
echo "</tr>";
}
echo "</table>";



if($_GET) { //checks whether delete button or update button pressed
	if(isset($_GET['Delete'])){
		deleteEntry();

	}elseif(isset($_GET['Update'])){
		updateEntry();
	}
}

//allows user to DELETE data

function deleteEntry() {
	$deletedQuery = mysql_query("SELECT `dateExercised` FROM `exercise` ORDER BY `typeOfExercise` LIMIT $buttonIdentifier-1, 1");
	mysql_query("DELETE FROM `exercise` WHERE `date'=$deletedQuery");
	echo "<script type = 'text/javascript'> alert('Entry successfully deleted! Please refresh your page.'); </script>";

	
}

//allows user to UPDATE data

function updateEntry() {
	$updatedQuery = mysql_query("SELECT `dateExercised` FROM `exercise` ORDER BY `typeOfExercise` LIMIT $buttonIdentifier-1, 1");
	mysql_query("UPDATE `exercise` SET `dateExercised`=$updateDate WHERE `dateExercised`=$updatedQuery"); //date
	mysql_query("UPDATE `exercise` SET `timeDone`=$updateTime WHERE `dateExercised`=$updatedQuery"); //time
	mysql_query("UPDATE `exercise` SET `amountOfTimeExercised`=$updateAmountOfTime WHERE `dateExercised`=$updatedQuery"); //amt of time
	mysql_query("UPDATE `exercise` SET `typeOfExercise`=$updateTypeOfExercise WHERE `dateExercised`=$updatedQuery"); //type fo exercise
	mysql_query("UPDATE `exercise` SET `notes`=$updateNotes WHERE `dateExercised`=$updatedQuery"); // notes
	
	echo "<script type = 'text/javascript'> alert('Entry successfully updated! Please refresh your page.'); </script>";
}



echo <<<_END
<h2>Update Entry (please make sure to reenter all values)</h2>
Type of Exercise: <input type="text" name="updateTypeOfExercise"/>
Amount of Time: <input type="text" name="updateAmountOFTime"/> 
Time: <input type="text" name="updateTime/>
Date: <input type="text" name="updateDate"/>	
Notes: <input type="text" name="updateNotes"/>	
_END;


mysql_close($db_server);

echo "</body>";
?>