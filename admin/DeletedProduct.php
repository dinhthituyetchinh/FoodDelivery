<?php
include '../config.php';
function loadClass($c)
{
    include "../class/$c.php";
}
spl_autoload_register('loadClass');

$model = new AdminController(new DB(new PDO("mysql:host=$servername;dbname=$dbname", $username, $password)));

$id = $_GET['PRODUCTID']??'';
$n = $model->DeletedProduct($id);

if($n == 0)
{
    ?>
        <script>
            alert('Không xoá được');
            window.location='ViewProduct.php';
        </script>
    <?php
    exit;
}
else
{
    ?>
        <script>
            alert('Đã xoá thành công');
            window.location='ViewProduct.php';
            </script>
    <?php
    exit;
}