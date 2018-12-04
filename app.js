$(document).ready(function(){
    //alert('Jquery');

    $('#btnAdd').click(function(){
        $('#pro_form')[0].reset();
        $('.modal-title').text("Add Productos");
        $('#action').val("Add");
        $('#operation').val("Add");
        $('#subir_img').html('');
    });

    //Reade
    var dataTable = $('#pro_data').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":[0, 3, 4],
                "orderable":false,
            },
        ],

    });

    //Insert
    $(document).on('submit', '#pro_form', function(event){
        event.preventDefault();
        var nombre = $('#txtnombre').val();
        var precio = $('#txtprecio').val();
        var extension = $('#pro_img').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
            {
                alert("Imagen invalida");
                $('#pro_img').val('');
                return false;
            }
        } 
        //alert(nombre+' '+precio);
        if(nombre != '' && precio != '')
        {
            $.ajax({
                url:"inserta.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                    alert(data);
                    $('#pro_form')[0].reset();
                    $('#producModal').modal('hide');
                    dataTable.ajax.reload();
                }
            });
        }else
        {
            alert("Datos Requiridos");
        }

    });

    //Update
    $(document).on('click', '.update', function(){
        var pro_id = $(this).attr("id");
        $.ajax({
            url:"edit.php",
            method:"POST",
            data:{pro_id:pro_id},
            dataType:"json",
            success:function(data)
            {
                console.log(data);
                $('#producModal').modal('show');
                $('#txtnombre').val(data.nombre);
                $('#txtprecio').val(data.precio);
                $('.modal-title').text("Actualizar Producto");
                $('#pro_id').val(pro_id);
                $('#img_subida').html(data.pro_image);
                $('#action').val("Actualizar");
                $('#operation').val("Edit");
            }
        })
    });

    //Delete
    $(document).on('click', '.delete', function(){
        var pro_id = $(this).attr("id");
        if(confirm("Esta seguro de remover el producto..?"))
        {
            $.ajax({
                url:"delete.php",
                method:"POST",
                data:{pro_id:pro_id},
                success:function(data)
                {
                    alert(data);
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false; 
        }
    });
});