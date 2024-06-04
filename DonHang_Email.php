<?php
session_start();
include 'config.php';  
include './mail/sendmail.php';

// Lấy thông tin người dùng từ session
$user = $_SESSION['user'];
$userId = $user['USERID'];

// Kiểm tra xem giỏ hàng có tồn tại không, nếu không, thoát quá trình xử lý
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if (empty($cart)) {
    echo "Giỏ hàng của bạn đang trống.";
    exit;
}


$orderId = rand(0, 9999);


$insert_order = "INSERT INTO orders (ORDERID, USERID) VALUES ('$orderId', '$userId')";

try {
    $conn->exec($insert_order);
    $totalPrice = 0;
  
    foreach ($_SESSION['cart'] as $key => $value) {
        $productid = $value['productID'];
        $soluong = $value['sl'];
        $price = $value['productPrice'];
        $insert_order_detail = "INSERT INTO orderdetail (ORDERID, PRODUCTID, QUANTITY, PRICE) VALUES ('$orderId', '$productid', '$soluong','$price')";
        $conn->exec($insert_order_detail);

        $totalPrice += $price * $soluong * 1000;
    }
    $totalPriceFormatted = number_format($totalPrice, 0, ',', '.') . " VND";

    $stmt = $conn->prepare("SELECT EMAIL FROM users WHERE USERID = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $userEmail = $stmt->fetchColumn();

    // Gửi email xác nhận 
    $tieude = "Đặt hàng website chinh2thuy.infinityfreeapp.com  thành công!";
    $noidung = "<p>Cảm ơn quý khách có mã người dùng là: $userId đã đặt hàng của chúng tôi.</p>";
    $noidung = "<p> Mã đơn hàng của bạn là: $orderId</p>";
    $noidung .= "<h4>Đơn đặt hàng bao gồm:</h4>";
    foreach ($_SESSION['cart'] as $key => $val) {
    $noidung .= "<ul style='border:1px solid blue; margin:10px;'>
                    <li>Tên sản phẩm: ".$val['productName']."</li>
                    <li>Mã sản phẩm: ".$val['productID']."</li>
                    <li>Số lượng: ".$val['sl']."</li>
                    <li>Giá: ".$val['productPrice']."</li>
                </ul>";
    
    }
    $noidung .= "<p>Tổng hóa đơn của đơn hàng là: $totalPriceFormatted</p>";

    if (!empty($userEmail) && filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $mail = new Mailer();
        $mail->dathangmail($tieude, $noidung, $userEmail);
    } else {
        echo "Địa chỉ email không hợp lệ.";
    }

} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}

// Xóa giỏ hàng sau khi lưu đơn hàng thành công
unset($_SESSION['cart']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="path_to_your_css_file.css">
    <link href="dn_dk.css" rel="stylesheet" type="text/css">
    <link href="templatemo_style.css" rel="stylesheet" type="text/css">
    <title>Order Confirmation</title>
    
</head>
<body>
    <div class="container">
        <h1 style='color: blue;'>Order placed successfully!</h1>
        <a href="index.php">
            <button class="btn btn-primary">Quay về trang chính</button>
        </a>
    </div>
</body>
</html>
