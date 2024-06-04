<?php

include 'config.php';

$keyword = isset($_GET['ten']) ? $_GET['ten'] : ''; 

$sql = "SELECT * FROM products WHERE PRODUCTNAME LIKE :keyword";
$stm = $conn->prepare($sql);

$searchTerm = "%" . $keyword . "%"; 
$stm->bindParam(':keyword', $searchTerm, PDO::PARAM_STR);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootstrap  -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="menu.css">
    <style>
        #products img {
            width: 50px;
        }
    </style>
</head>

<body style="height: 3600px;"> 
    <!--
    <form action="search.php" method="get"> 
        Ten <input type="text" name="ten" id="" value=" <?php echo htmlspecialchars($keyword); ?>">
        <input type="submit" value="Tim">
    </form>
    -->
    <form action="search.php" method="get">
              <input type="search" class="form-input" name="ten" placeholder="Search Here..." style="height: 40px; width: 300px;">
              <button type="submit" style="background: none; border: none;">
                  <i class="fa-solid fa-magnifying-glass" style="color: #ff8243;"></i>
              </button>
    </form>
    
    <div style="background-image: url(assets/images/menu-bg.png);"class="our-menu section bg-light repeat-img" id="menu">
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <?php foreach ($data as $item) { ?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="dish-box text-center">
                            <div class="dist-img">
                                <img src="./hinh/<?php echo $item->PICTURE ?>" alt="<?php echo htmlspecialchars($item->PRODUCTNAME); ?>">
                            </div>
                            <div class="dish-rating">
                                5 <i class="fa-regular fa-star" style="color: #ff8243;"></i>
                            </div>
                            <div class="dish-title">
                                <h3 class="h3-title"><?php echo $item->PRODUCTID ?></h3>
                            </div>
                            <div class="dish-title">
                                <h3 class="h3-title"><?php echo htmlspecialchars($item->PRODUCTNAME); ?></h3>
                            </div>
                            <div class="dist-bottom-row">
                                <p><strong>Price:</strong> Rs. <?php echo $item->PRICE ?></p>
                                <button class="dish-add-btn"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <div >
                                <center>
                                <a href="XemChiTiet.php?id=<?php echo $item->PRODUCTID ?>" class="btn mb-2" style="background-color: #ffffe0; border-color: #ffffe0; color: black;"> Xem Chi Tiết</a>     
                                </center>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.5.1.min.js"></script>

</body>

</html>

