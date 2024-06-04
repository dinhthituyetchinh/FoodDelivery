<?php
require "./header.php";
require "../config.php";
function loadClass($c)
{
    include "../class/$c.php";
}
spl_autoload_register('loadClass');
$model = new AdminController(new DB(new PDO("mysql:host=$servername;dbname=$dbname", $username, $password)));
$order = $model->index();
$type = $model->SelectTypeProduct();
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


<div class="mainAdd">
    <h2 class="text-center p-3 text-danger">ADD PRODUCT</h2>
    <form method="post" action="./AddProduct.php" enctype="multipart/form-data">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="productName" name="add_product_name" value="">
            <label for="productName">Product Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="" name="add_product_description" value="">
            <label for="productDescription">Product Description</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="" name="add_product_price" value="">
            <label for="price">Price</label>
        </div>
        <div class="form-floating mb-3">
            <input type="file" class="form-control" id="" name="add_product_img" value="">
             <label for="Address">Image</label>
         </div>

        <div class="form-floating mb-3">  
            <input type="date" class="form-control" id="" name="add_product_created_date" value="">   
            <label for="CreatedDate">Created Date</label>
        </div>

        <label for="productType">Product Type</label>
        <select class="form-select form-select-lg mb-3 form-control" multiple aria-label="Multiple select example" name="add_product_type">
        <?php
            foreach($type as $item)
            {
                ?>
                <option value="<?php echo $item->PROD_TYPE_ID ?>"><?php echo $item->PROD_TYPE_NAME ?></option>
                <?php
            }
        ?>
        </select>

        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-danger justify-content-lg-between">Add Product</button>
        </div>

    </form>
</div>

