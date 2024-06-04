<?php
    require "./header.php";
    require "../config.php";
    function loadClass($c)
    {
        include "../class/$c.php";
    }
    spl_autoload_register('loadClass');

    $model = new AdminController(new DB(new PDO("mysql:host=$servername;dbname=$dbname", $username, $password)));
    $products = $model->ViewProduct();
 
?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<div class="mainAdd">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>DESCRIPTION</th>
                <th>PRICE</th>
                <th>IMAGE</th>
                <th>CREATED_AT</th>
                <th>UPDATED_AT</th>
                <th>TYPE NAME</th>
                <th>ACTION</th>

            </tr>
        </thead>
        <tbody>
        <?php
            foreach($products as $item)
            {
                ?>
                <tr>
                    <td scope="row"><?php echo $item->PRODUCTID ?></td>
                    <td><?php echo $item->PRODUCTNAME ?></td>
                    <td><?php echo $item->PRODUCTDESCRIPTION ?></td>
                    <td><?php echo $item->PRICE ?></td>
                    <td><img src="../hinh/<?php echo $item->PICTURE ?> " width="70px" height="70px"/></td>
                    <td><?php echo $item->CREATED_AT_OF_PROD ?></td>
                    <td><?php echo $item->UPDATED_AT_OF_PROD ?></td>
                    <td><?php 
                    if (isset($item->PRODUCTID)) {
                        $type_name = $model->GetNameProductType($item->PROD_TYPE_ID);
                        if (is_array($type_name) && !empty($type_name)) {
                            $name = $type_name[0]->PROD_TYPE_NAME;
                            echo $name;
                        }
                    }
                      ?>
                     </td>

                    <td>
                        <a href="./DeletedProduct.php?PRODUCTID=<?php echo $item->PRODUCTID ?>" type="button" class="btn btn-danger mb-3 text-uppercase">deleted</a>
                        <a href="./ViewUpdatedProduct.php?PRODUCTID=<?php echo $item->PRODUCTID ?>" type="button" class="btn btn-danger mb-3 text-uppercase">Updated</a>

                    </td>
                </tr>

                <?php
            }
            ?>
        </tbody>
    </table>
    
      <div class="d-grid gap-2 col-6 mx-auto">
        <a href="./ViewAddProduct.php" type="button" class="btn btn-danger text-uppercase"> Add product</a>
    </div>
</div>