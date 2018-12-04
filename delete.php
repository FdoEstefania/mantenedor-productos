<?php

include('db.php');
//include("function.php");

if(isset($_POST["pro_id"]))
{
    $image = get_nombre_imagen($_POST["pro_id"]);
    if($image != '')
    {
        unlink("upload/" . $image);
    }
    $statement = $connec->prepare(
        "DELETE FROM tbl_productos WHERE id = :id"
    );
    $result = $statement->execute(
        array(
            ':id' => $_POST["pro_id"]
        )
    );

    if(!empty($result))
    {
        echo 'Registro eliminado';
    }
}

function get_nombre_imagen($pro_id)
{
    include('db.php');
    $statement = $connec->prepare("SELECT image FROM tbl_productos WHERE id = '$pro_id'");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        return $row["image"];
    }
}

?>