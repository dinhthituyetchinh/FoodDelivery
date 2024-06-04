
<?php
// Khai báo rằng đây là một trang con và sẽ được load qua template
define('BASEPATH', true) OR exit('No direct script access allowed');

 //------    chi tiet
$id = $_GET['id'] ?? '';

if (!empty($id)) {
    $sql = "SELECT * FROM products WHERE PRODUCTID = :id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute(); 
    $data = $stm->fetch(PDO::FETCH_OBJ);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="main.css">
    <style>
        .product-img {
            width: 100%;
            max-width: 550px;
            height: auto;
            border-radius: 50%;
            margin: 0 auto;
            display: block;
        }
    </style>
</head>
<body>

<nav id="menu">
    <div class="container">
        <a href="#"><img src="./hinh/logonhahang1.jpg" alt="Logo" style="width: 100px;height: 71px;"></a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="menu_product.php">Menu</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="DN_DK/login.html">Login</a></li>
            <li><a href="DN_DK/logout.php">Logout</a></li>

        </ul>
        <div id="content12">
            <form action="search.php" method="get">
                <input type="search" class="form-input" name="ten" placeholder="Search Here...">
                <button type="submit" style="background: none; border: none;">
                    <i class="fa-solid fa-magnifying-glass" style="color: #ff8243;"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <h1>Thanh toán thành công</h1>
    <p>Cảm ơn bạn đã thanh toán! Đơn hàng của bạn đã được xác nhận.</p>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>Social link</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia, tenetur.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <h3>Open Hours</h3>
                <p><i class="far fa-clock" style="color: #ff8243;"></i> Mon-Thurs : 9am - 22pm</p>
                <p><i class="far fa-clock" style="color: #ff8243;"></i> Fri-Sun : 11am - 22pm</p>
                <p><i class="fas fa-location-dot" style="color: #ff8243;"></i> 140 Lê Trọng Tấn, P. Tây Thạnh, Q. Tân Phú, TP. HCM</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.055957173488!2d106.61008491471898!3d10.782855892315342!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752904b0a91a4d%3A0xc7d0946483d0fd4d!2zMTQwIEzDqiBUcuG7o25nIFTDonkgVGjGsMahbiwgVMOhbmggUGjGsOG7nW5nLCBUw6F5IFBoxrDhu51uZywgVGjDoCBO4buZLCBLaMOqIFZp4buHdCBOYW0!5e0!3m2!1sen!2s!4v1622284552427!5m2!1sen!2s" width="400px" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <div class="col-md-3">
                <h3>Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="menu_product.php">Menu</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Company</h3>
                <ul>
                    <li><a href="index.php">Terms & Conditions</a></li>
                    <li><a href="#privacy">Privacy Policy</a></li>
                    <li><a href="menu_product.php">Cookie Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>
</body>
</html>
