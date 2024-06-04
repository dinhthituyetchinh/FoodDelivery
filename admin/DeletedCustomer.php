<?php
include '../config.php';
function loadClass($c)
{
    include "../class/$c.php";
}
spl_autoload_register('loadClass');

$model = new AdminController(new DB(new PDO("mysql:host=$servername;dbname=$dbname", $username, $password)));

$id = $_GET['USERID']??'';
$n = $model->Delete_Customer($id);

if($n == 0)
{
    ?>
        <script>
            alert('Không xoá được');
            window.location='ViewCustomers.php';
        </script>
    <?php
    exit;
}
else
{
    ?>
        <script>
            alert('Đã xoá thành công');
            window.location='ViewCustomers.php';
            </script>
    <?php
    exit;
}