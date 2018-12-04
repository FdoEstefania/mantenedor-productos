<?php
include('db.php');
//include('function.php');
if(isset($_POST["pro_id"]))
{
    $output = array();
    $statement = $connec->prepare(
        "SELECT * FROM tbl_productos WHERE id = '".$_POST["pro_id"]."' LIMIT 1"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        $output["nombre"] = $row["nombre"];
        $output["precio"] = $row["precio"];
        if($row["image"] != '')
        {
            $output['pro_image'] = '<img src="upload/'.$row["image"].'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_pro_image" value="'.$row["image"].'" />';
        }
        else
        {
            $output['pro_image'] = '<input type="hidden" name="hidden_pro_image" value="" />';
        }
    }
    //var_dump($output);
    echo json_encode($output);
}
?>
