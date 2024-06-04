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
 
?>

<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h3>Recent Order</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <td>ORDER_ID</td>
                    <td>PRODUCT_ID</td>
                    <td>NOTES</td>
                    <td>QUANTITY</td>
                    <td>PRICE</td>
                </tr>
            </thead>
            <tbody>
               
            <?php
            foreach($order as $item)
            {
                ?>
                <tr>
                    <td><?php echo $item->ORDERID ?></td>
                    <td>
                        <?php 
                        if (isset($item->ORDERID)) {
                            $p_name = $model->GetNameProduct($item->PRODUCTID);
                            if (is_array($p_name) && !empty($p_name)) {
                                $name = $p_name[0]->PRODUCTNAME;
                                echo $name;
                            }
                        }
                          ?>
                     </td>
                    <td><?php echo $item->NOTES ?></td>
                    <td><?php echo $item->QUANTITY ?></td>
                    <td><?php echo $item->PRICE ?></td>
                </tr>

                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <div>


    </div>
</div>


<?php  require "./footer.php"; ?>