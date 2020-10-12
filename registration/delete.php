<?php
session_start();
include('connection.php');
include('function.php');

if(isset($_POST["schedule_id"]))
{
	$statement = $connection->prepare(
		"DELETE FROM schedule WHERE s_id = :s_id"
	);
	$result = $statement->execute(

		array(':s_id'	=>	$_POST["schedule_id"])
		
	    );
}

?>
                           