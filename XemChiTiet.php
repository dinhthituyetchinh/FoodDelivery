<?php
 //------    chi tiet
 include 'config.php';
 include 'binhluan.php'; 
$id = $_GET['id'] ?? '';

if (!empty($id)) {
    $sql = "SELECT * FROM products WHERE PRODUCTID = :id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute(); 
    $data = $stm->fetch(PDO::FETCH_OBJ);
}
// Kiểm tra biến $success từ session để hiển thị thông báo
$success = isset($_SESSION['comment_success']) ? $_SESSION['comment_success'] : false;
unset($_SESSION['comment_success']);

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
    <link rel="stylesheet" href="style.css">
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
        .comment-form {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .comment-form input, .comment-form textarea {
            width: 100%;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .comment-list {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
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
          
    <div id="content13">
          <a href="ShowCart.php">
              <i class="fa-solid fa-cart-shopping"></i>
              <?php echo isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? count($_SESSION['cart']) : ''; ?>
          </a>
      </div>
        </nav>
     
        <!------------------ chi tiết món ăn---------------->
     <!--   <div class="container mt-5">
            <div class="row">
                <div class="col-lg-9">
                    <h2 class="text-center mb-4" style="color: #900;">THÔNG TIN CHI TIẾT SẢN PHẨM</h2>
                    <?php if (!empty($data)) { ?>
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text" name="productID">Mã sản phẩm: <?php echo $data->PRODUCTID; ?></p>
                                <p class="card-text" name="productName">Tên sản phẩm: <?php echo $data->PRODUCTNAME; ?></p>
                                <p class="card-text" name="productPrice">Giá: <?php echo $data->PRICE; ?></p>
                                <p class="card-text" name="productImg">Hình: <img src="./hinh/<?php echo $data->PICTURE; ?>" alt="" width="100"></p>
                               
                                <form class="form-inline" method="post" action="ShowCart.php">
                                <div class="d-flex align-items-center">
                                    <input type="number" name="sl" id="productQty" class="form-control mr-2" value="1" placeholder="Quantity" min="1" max="1000" style="width: 100px;">
                                    <button type="submit" class="btn btn-primary" name="add_to_cart" value="add to cart">CHO VÀO GIỎ</button>
                                </div>
                              </form>
                            </div>
                        </div>
                    <?php } else { ?>
                        <p>Không tìm thấy sản phẩm</p>
                    <?php } ?>
                </div>
            </div>
        </div>
                    -->   
     <div class="container mt-5">
    <div class="row">
        <div class="col-lg-9">
            <h2 class="text-center mb-4" style="color: #990000;">THÔNG TIN CHI TIẾT SẢN PHẨM</h2>
            <?php if (!empty($data)) { ?>
                <div class="card">
                    <div class="card-body">
                        <p class="card-text" name="productID">Mã sản phẩm: <?php echo $data->PRODUCTID; ?></p>
                        <p class="card-text" name="productName">Tên sản phẩm: <?php echo $data->PRODUCTNAME; ?></p>
                        <p class="card-text" name="productPrice">Giá: <?php echo $data->PRICE; ?></p>
                        <p class="card-text" name="productImg">Hình: <img src="./hinh/<?php echo $data->PICTURE; ?>" alt="" width="200"></p>
                        <form class="form-inline" method="post" action="ShowCart.php">
                            <div class="d-flex align-items-center">
                                <input type="number" name="sl" id="productQty" class="form-control mr-2" value="1" placeholder="Quantity" min="1" max="1000" style="width: 100px;">
                                <input type="hidden" name="productID" value="<?php echo $data->PRODUCTID; ?>">
                                <input type="hidden" name="productName" value="<?php echo $data->PRODUCTNAME; ?>">
                                <input type="hidden" name="productPrice" value="<?php echo $data->PRICE; ?>">
                                <input type="hidden" name="productImg" value="<?php echo $data->PICTURE; ?>">
                                <button type="submit" class="btn btn-primary" name="add_to_cart" value="add to cart">CHO VÀO GIỎ</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } else { ?>
                <p>Không tìm thấy sản phẩm</p>
            <?php } ?>
            
             <!------------------ Form bình luận -------------------->
             <hr>
            <h2 class="text-center mb-4" style="color: #990000;">BÌNH LUẬN</h2>
            <?php if (isset($_SESSION['user'])) { ?>
                <form action="binhluan.php" method="post" id="commentForm">
                    <input type="text" name="NAME" value="<?php echo $_SESSION['user']['FULLNAME']; ?>" placeholder="Tên của bạn" readonly><br>
                    <textarea name="NOIDUNG" id="NOIDUNG" cols="120" rows="5" placeholder="Nội dung bình luận"></textarea><br>
                    <input type="hidden" name="PRODUCTID" value="<?php echo $data->PRODUCTID; ?>">
                    <input type="hidden" name="USERID" value="<?php echo $_SESSION['user']['USERID']; ?>">
                    <input type="submit" class="btn btn-primary" value="Gửi bình luận" name="guibinhluan">
                </form>

                <?php if ($success) { ?>
                    <p style='color: green;'>Bình luận của bạn đã được gửi thành công!</p>
                    <script>
                        document.getElementById('commentForm').reset();
                    </script>
                <?php } ?>

                <hr>
                <h2 class="text-center mb-4" style="color: #0074D9;">DANH SÁCH BÌNH LUẬN</h2>
                <?php
                $dsbl = showbl();
                foreach ($dsbl as $bl) {
                    //echo $bl['NAME'].'-'.$bl['NOIDUNG'].'-'.$bl['PRODUCTID']."<br>";
                    echo "Tên người dùng: {$bl['NAME']} - Nội dung: {$bl['NOIDUNG']} - Mã sản phẩm: {$bl['PRODUCTID']}<br>";
                }
                ?>
            <?php } else { ?>
                <p><a href='./DN_DK/login.php' target='_parent'>Bạn vui lòng đăng nhập!</a></p>
            <?php } ?>
        </div>
    </div>
</div>

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
            <p><i class="far fa-user-friends" style="color: #FFCC36;"></i>&nbsp; Name: Chinh - Thúy - Thủy</p>
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



<script>
document.getElementById("commentForm").reset();
</script>


</html>



