<?php
include('db.php');
//include('function.php');

$query = '';
$output = array();

$query .= "SELECT * FROM tbl_productos ";
if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE nombre LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR precio LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
    $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= 'ORDER BY id DESC ';
}
if($_POST["length"] != -1)
{
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connec->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
//var_dump($result); 
$data = array();
$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
    $image = '';
    if($row["image"] != '')
    {
        $image = '<img src="upload/'.$row["image"].'" class="img-thumbnail" width="64" height="48" alt="image">';
    }
    else
    {
        $image = '';
    }
    $sub_array = array();
    $sub_array[] = $image;
    $sub_array[] = $row["nombre"];
    $sub_array[] = '$ '.$row["precio"];
    $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">editar</button>';
    $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">remover</button>';
    $data[] = $sub_array;
}

$output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  $filtered_rows,
    "recordsFiltered" => get_total(),
    "data"    => $data
);
if($output){
    echo json_encode($output);
}


//$this->error('No hay elementos');
//print_r($output);  


function get_total()
{
    include('db.php');
    $statement = $connec->prepare("SELECT * FROM tbl_productos");
    $statement->execute();
    $result = $statement->fetchAll();
    return $statement->rowCount();
}

function error($mensaje)
{
    echo '<code>'. json_encode(array('mensaje' => $mensaje)) .'</code>';
}
?>