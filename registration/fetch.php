<?php 

include('connection.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM schedule ";
if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE no_of_days LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR start_date LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR end_date LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR city LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR likes LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST["order"]))
{
    $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= 'ORDER BY s_id ASC ';
}

if($_POST["length"] != -1)
{
    $query .= 'LIMIT ' .$_POST['start']. ', ' .$_POST['length'];
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
    $sub_array = array();

    $sub_array[] = $row["s_id"];
    $sub_array[] = $row["no_of_days"];
    $sub_array[] = $row["start_date"];
    $sub_array[] = $row["end_date"];
    $sub_array[] = $row["city"];
    $sub_array[] = '<button type="button" name="show" id="'.$row["s_id"].'" class="btn btn-primary btn-sm update">Show</button>';
    $sub_array[] = '<button type="button" name="update" id="'.$row["s_id"].'" class="btn btn-primary btn-sm update">Edit</button>';
    $sub_array[] = '<button type="button" name="delete" id="'.$row["s_id"].'" class="btn btn-danger btn-sm delete">Delete</button>';
    $data[] = $sub_array;
}
$output = array(
    "draw"              =>  intval($_POST["draw"]),
    "recordsTotal"      =>  $filtered_rows,
    "recordsFiltered"   =>  get_total_all_records(),
    "data"              =>  $data
);
echo json_encode($output);
?>
                           