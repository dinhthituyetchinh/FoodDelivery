<?php
require "./header.php";
require "../config.php";
function loadClass($c)
{
    include "../class/$c.php";
}
spl_autoload_register('loadClass');

$p_id = $_GET['PRODUCTID'];
if(empty($p_id))
{
    header("location: ViewProduct.php");
}
$model = new AdminController(new DB(new PDO("mysql:host=$servername;dbname=$dbname", $username, $password)));

$update_prod = $model->GetProduct($p_id);
$type = $model->SelectTypeProduct();

// Kiểm tra nếu người dùng đã submit form
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy các giá trị từ form
    $update_p_name = $_POST['update_p_name'];
    $update_p_des = $_POST['update_p_des'];
    $update_p_price = $_POST['update_p_price'];
    $update_p_type = $_POST['update_p_type'];
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $update_date = date("d-m-Y");
    

    // Kiểm tra xem người dùng đã chọn file hình mới hay chưa
    if(isset($_FILES['update_p_img']) && $_FILES['update_p_img']['error'] == UPLOAD_ERR_OK) {
        // Nếu đã chọn file hình mới, thực hiện xử lý lưu file và cập nhật đường dẫn hình ảnh mới
        $update_p_img = $_FILES['update_p_img']['name'];
        move_uploaded_file($_FILES['update_p_img']['tmp_name'], "../hinh/$update_p_img");
    } else {
        // Nếu không chọn file hình mới, giữ nguyên đường dẫn hình ảnh cũ
        $update_p_img = $update_prod[0]->PICTURE;
    }

    $model->UpdateProduct($p_id, $update_p_name, $update_p_des, $update_p_price, $update_p_img, $update_date, $update_p_type);
    if(isset($model))
    {
        ?>
            
        <script>
            alert('Đã cập nhật thành công');
            window.location = 'ViewProduct.php';
        </script>     
        <?php
         exit;
    }
}

?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<div class="mainAdd">
    <h2 class="text-center p-3">UPDATES PRODUCT</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="productID" value="<?php if(isset($p_id)) echo $p_id; else echo ""?>" />
        <div class="form-floating mb-3 " >
        <img src="../hinh/<?php if(isset($p_id)) echo $update_prod[0]->PICTURE;?>" width="200px" height="200px" />
        </div>
        
        <div class="form-floating mb-3">
            <input type="text" class="form-control" value="
            <?php 
                if (isset($update_prod[0]->PROD_TYPE_ID)) {
                    $type_name = $model->GetNameProductType($update_prod[0]->PROD_TYPE_ID);
                    if (is_array($type_name) && !empty($type_name)) {
                        $name = $type_name[0]->PROD_TYPE_NAME;
                        echo $name;
                    }
                }
            ?>
        " readonly>
            <label for="productType">Product Type</label>

        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="productName" name="update_p_name" value="<?php if(isset($p_id)) echo $update_prod[0]->PRODUCTNAME;?>">
            <label for="productName">Product Name</label>

        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="productDescription" name="update_p_des" value="<?php if(isset($p_id)) echo $update_prod[0]->PRODUCTDESCRIPTION;?>">
            <label for="productDescription">Product Description</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="" name="update_p_price" value="<?php if(isset($p_id)) echo $update_prod[0]->PRICE;?>">
            <label for="price">Price</label>
        </div>
    
        <div class="form-floating mb-3">
        <input type="file" class="form-control" id="" name="update_p_img">
            <label for="Address">Update Image</label>
        </div>
        <label for="productType">Update Product Type</label>
        <select class="form-select form-select-lg mb-3 form-control" multiple aria-label="Multiple select example" name="update_p_type">
        <?php
            foreach($type as $item)
            {
                ?>
                <option value="<?php echo $item->PROD_TYPE_ID ?>"><?php echo $item->PROD_TYPE_NAME ?></option>
                <?php
            }
        ?>
        </select>
        <div class="form-floating mb-3">
            <input type="hidden" class="form-control" id="UpdatedDate" name="update_date" value="<?php 
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        echo date("d-m-Y");
        ?>
">
           
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-danger justify-content-lg-between">Updates Product</button>
        </div>

    </form>
</div>