<?php
    require "./header.php";
    require "../config.php";
    function loadClass($c)
    {
        include "../class/$c.php";
    }
    spl_autoload_register('loadClass');

    $model = new AdminController(new DB(new PDO("mysql:host=$servername;dbname=$dbname", $username, $password)));
    $customers = $model->ViewCustomers();
 
?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<div class="mainAdd">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>FULLNAME</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>DAYOFBIRTH</th>
                <th>ADDRESS</th>
                <th>CREATED_AT</th>
                <th>UPDATED_AT</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($customers as $item)
            {
                ?>
                <tr>
                    <td scope="row"><?php echo $item->USERID ?></td>
                    <td><?php echo $item->FULLNAME ?></td>
                    <td><?php echo $item->PHONE ?></td>
                    <td><?php echo $item->EMAIL ?></td>
                    <td><?php echo $item->DAYOFBIRTH ?></td>
                    <td><?php echo $item->USERADDRESS ?></td>
                    <td><?php echo $item->CREATEDAT ?></td>
                    <td><?php echo $item->UPDATEDAT ?></td>
                    <td>
                        <a href="./DeletedCustomer.php?USERID=<?php echo $item->USERID ?>" type="button" class="btn btn-danger mb-3 text-uppercase">deleted</a>
                    </td>
                </tr>

                <?php
            }
            ?>
        </tbody>
    </table>
         
</div>