<?php
session_start();
include 'config.php'; 
include 'Pager.php';
spl_autoload_register(function ($class_name) {
    include 'class/' . $class_name . '.php';
});

$db = new DB($conn);


$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$prodTypeId = null;

if (isset($_GET['menu_tab'])) {
    $menuTab = $_GET['menu_tab'];

    // Phân loại PROD_TYPE_ID tương ứng với từng menu_tab
    switch ($menuTab) {
        case 'ga':    
            $prodTypeId = 5;   //PROD_TYPE_ID của gà trong bảng PRODUCTTYPE
            break;
        case 'drink':
            $prodTypeId = 1;
            break;
        case 'pizza':
            $prodTypeId = 3;
            break;
        case 'banhtrang':
            $prodTypeId = 21;
            break;
        case 'changanuong':
            $prodTypeId = 22;
            break;
        case 'bapxao':
            $prodTypeId = 23;
            break;
    }
}

// Loại sản phẩm
$menuTab = isset($_GET['menu_tab']) ? $_GET['menu_tab'] : 'all';

$sql = "SELECT p.PRODUCTID, p.PRODUCTNAME, p.PRICE, p.PICTURE, t.PROD_TYPE_NAME
        FROM products p
        INNER JOIN producttype t ON p.PROD_TYPE_ID = t.PROD_TYPE_ID
        WHERE 1";

if (!empty($keyword)) {
    $sql .= " AND p.PRODUCTNAME LIKE :keyword";
}

if ($prodTypeId !== null) {
    $sql .= " AND p.PROD_TYPE_ID = :prodTypeId";
}

$stm = $db->prepare($sql);

if (!empty($keyword)) {
    $ten = "%" . $keyword . "%";
    $stm->bindParam(':keyword', $ten, PDO::PARAM_STR);
}

if ($prodTypeId !== null) {
    $stm->bindParam(':prodTypeId', $prodTypeId, PDO::PARAM_INT);
}
try 
{
  $stm->execute();   
  $data = $stm->fetchAll(PDO::FETCH_OBJ);
} 
catch (Exception $e) 
{    
  
}

 //------    chi tiet
 $productDetail = null;
 include 'config.php'; 
$id = $_GET['id'] ?? '';

if (!empty($id)) {
    $sql = "SELECT * FROM products WHERE PRODUCTID = :id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute(); 
    $data = $stm->fetch(PDO::FETCH_OBJ);
}
//----------------  Xử lý phân trang

$p = new Pager(); 
$count = count($data);
$limit = 6; 
$cur = isset($_GET["page"]) ? $_GET["page"] : 1; 
$start = $p->findStart($limit); // tìm vị trí bắt đầu của bản ghi
$phantrang = ceil($count / $limit);

// sql phân trang
$sql = "SELECT p.PRODUCTID, p.PRODUCTNAME, p.PRICE, p.PICTURE, t.PROD_TYPE_NAME
        FROM products p 
        INNER JOIN producttype t ON p.PROD_TYPE_ID = t.PROD_TYPE_ID";

if ($menuTab !== 'all') {
    $sql .= " WHERE p.PROD_TYPE_ID = :prodTypeId";
}

$sql .= " LIMIT :start, :limit";
$stm = $conn->prepare($sql);

// Nếu menu_tab không được xác định hoặc menu_tab=all, không cần gán giá trị cho :prodTypeId
if ($menuTab !== 'all') {
    $stm->bindParam(':prodTypeId', $prodTypeId, PDO::PARAM_INT);
}

$stm->bindParam(':start', $start, PDO::PARAM_INT);
$stm->bindParam(':limit', $limit, PDO::PARAM_INT);
$stm->execute(); 
$data = $stm->fetchAll(PDO::FETCH_OBJ);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"> 
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

       <!-- <div id="content12">
            <input type="search" class="form-input" placeholder="Search Here..." style="height: 40px;width: 180px;">
            <button type="submit">
              <a href="search.php"><i class="fa-solid fa-magnifying-glass" style="color: #ff8243;"></i>
            </button>
          </div>
        -->

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
      
     
<!------------------- menu product------------------->
         <div class="our-menu section bg-light repeat-img" style="background-image: url(assets/images/menu-bg.png);">
            <div class="sec-wp">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sec-title text-center mb-5">
                                <p class="sec-sub-title mb-3">Our Menu</p>
                                <h2 class="h2-title">Wake Up Early, <span>Eat Fresh & Healthy</span></h2>
                                <div class="sec-title-shape mb-4">
                                    <img src="assets/images/title-shape.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>              
                    <!------------------     loại sp     ---------------------->
                    <div class="menu-tab-wp">
                        <div class="row">
                            <div class="col-lg-12 m-auto">
                                <div class="menu-tab text-center">
                                    <ul class="filters">
                                        <li class="filter" data-filter="all">
                                            <img src="./hinh/menu-1.png" alt="">
                                            <a href="?menu_tab=all">All</a>   
                                        </li>
                                        <li class="filter" data-filter="ga">
                                            <img src="./hinh/menu-ga.png" alt="">
                                            <a href="?menu_tab=ga">Gà rán</a>
                                        </li>
                                        <li class="filter" data-filter="drink">
                                            <img src="./hinh/menu-7up.png" alt="">
                                            <a href="?menu_tab=drink">Drink</a>
                                        </li>
                                        <li class="filter" data-filter="pizza">
                                            <img src="./hinh/menu-pizza.png" alt="">
                                            <a href="?menu_tab=pizza">Pizza</a>
                                        </li>
                                        <li class="filter" data-filter="banhtrang">
                                            <img src="./hinh/menu-banhtrang.png" alt="">
                                            <a href="?menu_tab=banhtrang">Bánh tráng</a>
                                        </li>
                                        <!--
                                        <li class="filter" data-filter="changanuong">
                                            <img src="/hinh/menu-changanuong.png" alt="">
                                            <a href="?menu_tab=changanuong">Chân gà nướng</a>
                                        </li>
                                        -->
                                        <li class="filter" data-filter="bapxao">
                                            <img src="./hinh/menu-bapxao.png" alt="">
                                            <a href="?menu_tab=bapxao">Bắp xào</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------------------------>
                        <div class="container">
                        <div class="row">
                        <?php foreach ($data as $item) { ?>
                                <div class="col-lg-4 col-sm-6 mix <?php echo str_replace(' ', '-', $item->PROD_TYPE_NAME) ?>">
                                    <div class="dish-box text-center">
                                        <div class="dist-img">
                                            <img src="./hinh/<?php echo $item->PICTURE ?>" alt="<?php echo $item->PRODUCTNAME ?>">
                                        </div>
                                         <!---------------------- đánh giá sao--------------------------->
                                        <div class="dish-rating">
                                            <section class='rating-widget'>
                                                <?php
                                               $PRODUCTID = $item->PRODUCTID;
                                               $sql_star = "SELECT AVG(rating) as avg_star FROM danhgiasao WHERE PRODUCTID = :PRODUCTID";
                                               $stm_star = $conn->prepare($sql_star);
                                               $stm_star->bindParam(':PRODUCTID', $PRODUCTID, PDO::PARAM_INT);
                                               $stm_star->execute();
                                               $avg_star = $stm_star->fetch(PDO::FETCH_ASSOC)['avg_star'];
                                                ?>
                                                <div class='rating-stars text-center'>
                                                    <ul id='stars'>
                                                        <?php
                                                        for ($j = 1; $j <= 5; $j++) {
                                                            $selected = $j <= $avg_star ? 'selected' : '';
                                                        ?>
                                                            <li class='star <?php echo $selected ?>' title='Poor' data-value='<?php echo $j; ?>' data-PRODUCTID='<?php echo $PRODUCTID; ?>'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </section>
                                        </div>
                                         <!------------------------------------------------------------>
                                        <div class="dish-title">
                                            <h3 class="h3-title"><?php echo $item->PRODUCTID ?></h3>
                                        </div>
                                        <div class="dish-title">
                                            <h3 class="h3-title"><?php echo $item->PRODUCTNAME ?></h3>
                                        </div>
                                        <div class="dist-bottom-row">
                                            <p><strong>Price:</strong> Rs. <?php echo $item->PRICE ?></p>
                                            <button class="dish-add-btn"><i class="fa-solid fa-plus"></i></button>
                                        </div >
                                        <div >
                                            <center>
                                            <a href="XemChiTiet.php?id=<?php echo $item->PRODUCTID ?>" class="btn mb-2" style="background-color: #ffffe0; border-color: #ffffe0; color: black;"> Xem Chi Tiết</a>     
                                            </center>
                                        </div>
                                        
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                             <!--
                            <div style="margin: 20px; text-align: center;">
                           < ?php echo $p->pageList($cur, $phantrang); ?>
                            </div>
                        -->
                         
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php echo $p->pageListBootstrap($cur, $phantrang); ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>            
             
    <div class="dong3c1">
        <img src="./hinh/pizza.png">
    </div>
    <div class="dong3c2">
        <img src="./hinh/sushi.png">        
    </div>
<!------------------- menu product------------------->

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
            <p style="padding-top: 15px;"><i class="fa-regular fa-clock" style="color: #ff8243;"></i>&nbsp; Mon-Sun : 9am - 22pm</p>
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

<!------ ----------- dánh giá sao   ---------------->
<script>
$(document).ready(function() {
    $('#stars li').on('mouseover', function() {
        var onStar = parseInt($(this).data('value'), 10);
        $(this).parent().children('li.star').each(function(e) {
            if (e < onStar) {
                $(this).addClass('hover');
            } else {
                $(this).removeClass('hover');
            }
        });
    }).on('mouseout', function() {
        $(this).parent().children('li.star').each(function(e) {
            $(this).removeClass('hover');
        });
    });

    $('#stars li').on('click', function() {
        var onStar = parseInt($(this).data('value'), 10);
        var stars = $(this).parent().children('li.star');
        var PRODUCTID = $(this).data('productid'); 

        
        for (var i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }

        for (var i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }

        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
        var msg = "";
        if (ratingValue > 1) {
            msg = "Thanks! You rated this " + ratingValue + " stars.";
        } else {
            msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
        }
        responseMessage(msg);

        $.ajax({
            url: 'danhgiasao.php',
            method: 'POST',
            data: {
                rating: onStar,
                PRODUCTID: PRODUCTID
            },
            success: function(response) {
                console.log('Rating saved successfully!');
                console.log(response);  
            },
            error: function(xhr, status, error) {
                console.error('Error saving rating:', error);
            }
        });
    });
});

function responseMessage(msg) {
    $('.success-box').fadeIn(200);
    $('.success-box div.text-message').html("<span>" + msg + "</span>");
}
</script>

</html>