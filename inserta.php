<?php
include('db.php');
//include('function.php');

if(isset($_POST["operation"]))
{
    //Insertar
    if($_POST["operation"] == "Add")
    {

        $image = '';
        if($_FILES["pro_img"]["name"] != '')
        {
            //echo $_POST["txtnombre"].'-'.$_POST["txtprecio"].'-'.$image;
            $image = upload_imagen();
        }
        $sql = "INSERT INTO tbl_productos (nombre, precio, image) VALUES (:nombre, :precio, :image)";

        $statement = $connec->prepare($sql);
        $result = $statement->execute(
            array(
                ':nombre'	=>	$_POST["txtnombre"],
                ':precio'	=>	$_POST["txtprecio"],
                ':image'  => $image

            )
        );
        if(!empty($result))
        {
            echo 'Producto Insertado';
        }
    }
    
    //Actualizar
    if($_POST["operation"] == "Edit")
    {
        $image = '';
        if($_FILES["pro_image"]["name"] != '')
        {
            $image = upload_image();
        }
        else
        {
            $image = $_POST["hidden_pro_image"];
        }
        $statement = $connec->prepare(
            "UPDATE tbl_productos SET nombre = :nombre, precio = :precio, image = :image  WHERE id = :id"
        );
        $result = $statement->execute(
            array(
                ':nombre' => $_POST["txtnombre"],
                ':precio' => $_POST["txtprecio"],
                ':image'  => $image,
                ':id'   => $_POST["pro_id"]
            )
        );
        if(!empty($result))
        {
            echo 'Pruducto actualizado';
        }
    }

}

function upload_imagen()
{
    if(isset($_FILES["pro_img"]))
    {
        $extension = explode('.', $_FILES['pro_img']['name']);
        $new_name = rand() . '.' . $extension[1];
        $destination = './upload/' . $new_name;
        move_uploaded_file($_FILES['pro_img']['tmp_name'], $destination);
        return $new_name;

    }
}
?>