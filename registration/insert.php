<?php 
session_start();
include('connection.php');
include('function.php');
$uid = $_SESSION[uid];

if(isset($_POST["operation"]))
{
    if($_POST["operation"] == "Add")
    {
        $statement = $connection->prepare("INSERT INTO schedule (u_id, no_of_days, start_date, end_date, city, likes) VALUES (:uid, :no_of_days, :start_date, :end_date, :city, :likes)");
        $result = $statement->execute(
             array(
                'uid' => $_SESSION["uid"],
                ':no_of_days'   =>  $_POST["no_of_days"],
                ':start_date' =>  $_POST["start_date"],
                ':end_date' =>  $_POST["end_date"],
                ':city' =>  $_POST["city"],
                ':likes' => $_POST["insert"],
             )
        );
    }
    if($_POST["operation"] == "Edit")
    {
        $statement = $connection->prepare("UPDATE schedule SET no_of_days = :no_of_days, start_date = :start_date, end_date = :end_date, city = :city, likes = :likes WHERE s_id = :s_id");
        $result = $statement->execute(
             array(
                ':no_of_days'   =>  $_POST["no_of_days"],
                ':start_date' =>  $_POST["start_date"],
                ':end_date' =>  $_POST["end_date"],
                ':city' =>  $_POST["city"],
                ':s_id' =>  $_POST["schedule_id"],
                ':likes' => $_POST["insert"],
             )
        );
    }
    
}
?>
                           