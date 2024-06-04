<?php
require "./header.php";
require "../config.php";
function loadClass($c)
{
    include "../class/$c.php";
}
spl_autoload_register('loadClass');

$p_name = $_POST['add_product_name'];
$p_des = $_POST['add_product_description'];
$p_price = $_POST['add_product_price'];
$p_img = $_FILES['add_product_img']['name'];
$p_created_at = $_POST['add_product_created_date'];
$p_type = $_POST['add_product_type'];
$model = new AdminController(new DB(new PDO("mysql:host=$servername;dbname=$dbname", $username, $password)));

$n = $model->AddProduct($p_name, $p_des, $p_price, $p_img, $p_created_at, $p_type);
if($n > 0)
{
    move_uploaded_file($_FILES['add_product_img']['tmp_name'], "../hinh/$img");
}

?>

<script>
    alert('Đã thêm +<?php echo $n ?> dòng mới');
    window.location = 'ViewProduct.php';
</script>
