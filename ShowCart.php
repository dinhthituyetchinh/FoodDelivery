<?php
 //------    chi tiet
 include 'config.php';
 
$id = $_GET['id'] ?? '';

if (!empty($id)) {
    $sql = "SELECT * FROM products WHERE PRODUCTID = :id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();
    $data = $stm->fetch(PDO::FETCH_OBJ);
}
//Giỏ hàng
session_start();
//Nếu chưa tồn tại thì khởi tạo giỏ
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

//Xoá all giỏ
if (isset($_GET['emptyCart']) && ($_GET['emptyCart'] == 1)) unset($_SESSION['cart']);

//xoá item trong giỏ
if (isset($_GET['delId']) && ($_GET['delId']) >= 0) {
    array_splice($_SESSION['cart'], $_GET['delId'], 1);
}

//Update item trong giỏ
if (isset($_GET['updateId']) && ($_GET['updateId']) >= 0) {
    $index = ($_GET['updateId']);
    if (isset($_SESSION['cart'][$index])) {
        $new_quantity = $_GET['num_sl'] ?? 1;
        $_SESSION['cart'][$index]['sl'] = $new_quantity;
    }
}

//Lấy dữ liệu từ form xem chi tiết
if (isset($_POST['add_to_cart']) && ($_POST['add_to_cart'])) {
    $masp = $_POST['productID'] ?? '';
    $tensp = $_POST['productName'] ?? '';
    $hinh = $_POST['productImg'] ?? '';
    $donGia = $_POST['productPrice'] ?? 0;
    $sl = $_POST['sl'] ?? 1;

    //kiểm tra sp trong giỏ hàng
    $flag = 0;
    $count = count($_SESSION['cart']);
    for ($i = 0; $i < $count; $i++) {
        $item = $_SESSION['cart'][$i];
        if (isset($item["productID"]) && $item["productID"] == $masp) {
            $flag = 1;
            $sl_new = (int)$sl + (int)$item["sl"];
            $item["sl"] = $sl_new; //cập nhật sl trực tiếp trong mảng $_SESSION['cart']
            $_SESSION['cart'][$i] = $item;
            break;
        }
    }
    //thêm sp vào giỏ nếu ko trùng
    if ($flag == 0) {
        $sp = array(
            'productID' => $masp,
            'productName' => $tensp,
            'productImg' => $hinh,
            'productPrice' => $donGia,
            'sl' => (int)$sl,
        );
        $_SESSION['cart'][] = $sp;
    }
}

// Địa chỉ
$sql = "SELECT * FROM province";
$stm = $conn->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['add_sale'])) {
    echo "<pre>";
    print_r($_POST);
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Website</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="menu.css">
    <script src="jscript/app.js"></script>
    <style>

        .dong3c1 img {
            width: 550px;
            height: 550px;
            border-radius: 50%;
            margin-left: 100px;
            margin-top: 150px;
        }
        .dong3c2 img {
            width: 550px;
            height: 550px;
            border-radius: 50%;
            margin-left: 850px;
            margin-top: 150px;
        }
        #products img {
            width: 50px;
        }
    </style>
</head>
<body>
<nav id="menu">
          <span><img src="./hinh/logonhahang1.jpg" style="width: 100px;height: 71px;position: absolute;margin-top: -20px;"></span>
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#section2">About</a></li>
            <li><a href="menu_product.php">Menu</a></li>
            <li><a href="#section6">Contact</a></li>
            <li><a href="DN_DK/login.html">Login</a></li>
            <li><a href="DN_DK/logout.php">Logout</a></li>
          </ul>

      

        <!-----------------  tìm kiếm    ---------------->
        <div id="content12">
          <form action="search.php" method="get">
              <input type="search" class="form-input" name="ten" placeholder="Search Here..." style="height: 40px; width: 180px;">
              <button type="submit" style="background: none; border: none;">
                  <i class="fa-solid fa-magnifying-glass" style="color: #ff8243;"></i>
              </button>
          </form>
      </div>
          <!--------------------------------------------->
          
         
    <div id="content13">
          <a href="ShowCart.php">
              <i class="fa-solid fa-cart-shopping"></i>
              <?php echo isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? count($_SESSION['cart']) : ''; ?>
          </a>
      </div>

        </nav>
     
        <!------------------ chi tiết giỏ hàng---------------->
        <div class="col-9">
    <h2>THÔNG TIN GIỎ HÀNG CỦA BẠN</h2>
    <?php
    if (empty($_SESSION['cart'])) { ?>
        <table class="table">
            <tr>
                <td>
                    <p style="color: #900;">Your cart is empty</p>
                </td>
            </tr>
        </table>
    <?php
    }
    ?>
    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalCounter = 0;
                $itemCounter = 0;
                $count = count($_SESSION['cart']);
                for ($i = 0; $i < $count; $i++) {
                    $item = $_SESSION['cart'][$i];

                    // Ensure the necessary keys are present
                    $productImg = isset($item["productImg"]) ? $item["productImg"] : 'default.jpg';
                    $productName = isset($item["productName"]) ? $item["productName"] : 'Unknown Product';
                    $productPrice = isset($item["productPrice"]) ? $item["productPrice"] : 0;
                    $quantity = isset($item["sl"]) ? $item["sl"] : 1;

                    $imgUrl = "./hinh" . "/" . $productImg;
                    $total = (float)$productPrice * (int)$quantity*1000;
                    $totalCounter += $total;
                    $itemCounter += $quantity;
                ?>
                    <tr>
                        <td>
                            <img src="<?php echo $imgUrl; ?>" alt="" class="rounded img-thumbnail mr-2" style="width: 70px;">
                            <?php echo $productName; ?>
                            <a href="ShowCart.php?delId=<?php echo $i ?>" class="text-danger">
                                <i class="fa fa-trash fa-2"></i>
                            </a>
                        </td>
                        <td>
                            <?php echo $productPrice; ?> VNĐ
                        </td>
                        <td>
                            <form action="ShowCart.php" method="get">
                                <input type="hidden" name="updateId" id="input" class="form-control" value="<?php echo $i ?>">
                                <input type="number" name="num_sl" id="input" class="cart-qty-single" data-item="<?php echo $i ?>" value="<?php echo $quantity; ?>" min="1" max="1000">
                                <button type="submit" class="text-primary"><i class="fas fa-edit"></i></button>
                            </form>
                        </td>
                        <td>
                            <?php echo $total ?> VNĐ
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr class="border-top border-bottom">
                    <td><a href="ShowCart.php?emptyCart=1" class="btn btn-danger btn-sm">Clear Cart</a></td>
                    <td></td>
                    <td>
                        <strong>
                            <?php
                            echo ($itemCounter == 1) ? $itemCounter . ' item' : $itemCounter . ' items';
                            ?>
                        </strong>
                    </td>
                    <td><strong><?php echo $totalCounter ?> VNĐ</strong></td>
                </tr>
            </tbody>
        </table>
        <!-- Nút Check Out -->
        <div class="row">
            <div class="col-md-11">
                <?php if (isset($_SESSION['user'])) { ?>
                    <a href="./DonHang_Email.php">
                        <button type="submit" class="btn btn-primary btn-lg float-right">Thanh toán khi nhận</button>
                    </a>
                <?php } else { ?>
                    <a href="./DN_DK/login.php?checkout=true">
                        <button class="btn btn-primary btn-lg float-right">Thanh toán khi nhận</button>
                    </a>
                <?php } ?>
            </div>
            
            <div class="col-md-1">
                <?php if (isset($_SESSION['user']) || isset($_SESSION['usergg'])) { ?>
                    <form action="./OnlineCheckOut.php" method="post">
                        <input type="hidden" name="totalCounter" value="<?php echo $totalCounter; ?>">
                        <button type="submit" class="btn btn-primary btn-lg float-right">Thanh toán MOMO</button>
                    </form>
                <?php } else { ?>
                    <a href="./DN_DK/login.php?checkout=true">
                        <button class="btn btn-primary btn-lg float-right">Thanh toán MOMO</button>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<!---------  Dịa chỉ  --------->
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <script src="jscript/app.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <form id="myForm" class="mt-5" method="POST" action="update_address.php">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <h1 class="py-5">Chọn địa chỉ khi đặt hàng trong website</h1>
        
        <?php if (isset($_SESSION['address_update_success'])) { ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['address_update_success']; unset($_SESSION['address_update_success']); ?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="province">Tỉnh/Thành phố</label>
                    <select id="province" name="province" class="form-control">
                        <option value="">Chọn một tỉnh</option>
                        
                        <?php
                        foreach ($result as $row) {
                        ?>
                            <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="district">Quận/Huyện</label>
                    <select id="district" name="district" class="form-control">
                        <option value="">Chọn một quận/huyện</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="wards">Phường/Xã</label>
                    <select id="wards" name="wards" class="form-control">
                        <option value="">Chọn một xã</option>
                    </select>
                </div>
                <input type="submit" name="add_address" class="btn btn-primary w-100 form-input my-3" value="Update Address">
            </div>
        </div>
    </form>
</div>

</body>
</html>
         <!-------------------------------------------------------->
        
    <section id="section6" style="height: 700px;">
        <div class="main">
          <div class="main1">
            <h3>Social link</h3>
            <p style="padding-left: 14px;">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia, tenetur.</p>
            <p><a href="#"><i class="fa-brands fa-facebook"></i></a></p>
            <p><a href="#"><i class="fa-brands fa-instagram"></i></a></p>
            <p><a href="#"><i class="fa-brands fa-linkedin"></i></a></p>
            <p><a href="#"><i class="fa-brands fa-youtube"></i></a></p>
          </div>
          <div class="main2">
            <h3>Open Hours</h3>
            <p style="padding-top: 15px;"><i class="fa-regular fa-clock" style="color: #ff8243;"></i>&nbsp; Mon-Sun: 9am - 22pm</p>
            <p><i class="fa-regular fa-clock" style="color: #ff8243;"></i>&nbsp;  SDT: 0983860756 - 0886704540</p>
            <p><i class="fa-solid fa-location-dot"style="color: #ff8243"></i>&nbsp;  140 lê trọng tấn p. tây thạnh q. tân phú tp. hcm</p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.055957173488!2d106.61008491471898!3d10.782855892315342!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752904b0a91a4d%3A0xc7d0946483d0fd4d!2zMTQwIEzDqiBUcuG7o25nIFTDonkgVGjGsMahbiwgVMOhbmggUGjGsOG7nW5nLCBUw6F5IFBoxrDhu51uZywgVGjDoCBO4buZLCBLaMOqIFZp4buHdCBOYW0!5e0!3m2!1sen!2s!4v1622284552427!5m2!1sen!2s" width="400px" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            <p></p>
          </div>
          <div class="main3">
            <h3>Links</h3>
            <p><a href="index.php">Home</a></p>
            <p><a href="#section2">About</a></p>
            <p><a href="menu_product.php">Menu</a></p>
            <p><a href="#section6">Contact</a></p>
          </div>
          <div class="main4">
            <h3>Company</h3>
            <p><a href="index.php">Terms & Conditions</a></p>
            <p><a href="#section2">Privacy Policy</a></p>
            <p><a href="menu_product.php">Cookie Policy</a></p>
          </div>
        </div>
        </section>
      </div>
    

<!-----------------------    loai            ---------->
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const filters = document.querySelectorAll('.filters li');

    filters.forEach(filter => {
        filter.addEventListener('click', function() {
            filters.forEach(item => {
                item.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
});

</script>

<!----------------------------------------------------->
<script src="main1.js"></script>
      <script src="assets/js/jquery-3.5.1.min.js"></script>
<!-- bootstrap -->



<!-- swiper slider  -->
<script src="assets/js/swiper-bundle.min.js"></script>

<!-- mixitup -- filter  -->
<script src="assets/js/jquery.mixitup.min.js"></script>

<!-- parallax  -->
<script src="assets/js/parallax.min.js"></script>

<!-- gsap  -->
<script src="assets/js/gsap.min.js"></script>
<script src="main1.js"></script>
</body>
<!-- jquery  -->
<script src="assets/js/jquery-3.5.1.min.js"></script>

<!-- bootstrap -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mixitup/dist/mixitup.min.js"></script>

<!-- swiper slider  -->
<script src="assets/js/swiper-bundle.min.js"></script>

<!-- mixitup -- filter  -->
<script src="assets/js/jquery.mixitup.min.js"></script>

<!-- parallax  -->
<script src="assets/js/parallax.min.js"></script>

<!-- gsap  -->
<script src="assets/js/gsap.min.js"></script>

<script src="menu.js"></script>

</html>
