<?php

function get_total_all_records()
{
	include('connection.php');
	$statement = $connection->prepare("SELECT * FROM schedule");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>