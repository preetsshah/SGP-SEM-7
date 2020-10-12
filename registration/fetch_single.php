<?php 
session_start();
include('connection.php');
include('function.php');

if(isset($_POST["schedule_id"]))
{
    $output = array();
    $statement = $connection->prepare("SELECT * FROM schedule WHERE s_id = '".$_POST["schedule_id"]."' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        $output["s_id"] = $row["s_id"];
        $output["no_of_days"] = $row["no_of_days"];
        $output["start_date"] = $row["start_date"];
        $output["end_date"] = $row["end_date"];
        $output["city"] = $row["city"];
    }
    echo json_encode($output);
}
?>
                           