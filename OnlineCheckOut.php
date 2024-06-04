<?php
session_start();

if (!isset($_SESSION['user']) && !isset($_SESSION['usergg'])) {
    header('Location: ./DN_DK/login.php');
    exit;
}

$pdo = new PDO('mysql:host=localhost;dbname=fastfood', 'root', '');

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $userId = $user['USERID'];
} else {
   // $user = $_SESSION['usergg'];
   $_SESSION['usergg'] = $result; 
    $userId = $user['USERID']; // thay đổi 'USERID' thành 'id' 
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    echo "Your cart is empty.";
    exit;
}

$totalPrice = isset($_POST['totalCounter']) ? (float)$_POST['totalCounter'] : 0;
var_dump($totalPrice); // Kiểm tra giá trị của $totalPrice

// Tạo orders
$stmt = $pdo->prepare("INSERT INTO orders (USERID, TOTAL_PRICE, STATUS_OF_ORDER) VALUES (:USERID, :TOTAL_PRICE, 'Pending')");
$stmt->execute(['USERID' => $userId, 'TOTAL_PRICE' => $totalPrice]);

// Lấy ID của đơn hàng vừa tạo
$orderId = $pdo->lastInsertId();

// Lưu chi tiết dh orderdetail
foreach ($cart as $item) {
    $stmt = $pdo->prepare("INSERT INTO orderdetail (ORDERID, PRODUCTID, NOTES, QUANTITY, PRICE) VALUES (:ORDERID, :PRODUCTID, :NOTES, :QUANTITY, :PRICE)");
    $stmt->execute([
        'ORDERID' => $orderId,
        'PRODUCTID' => $item['productID'],
        'NOTES' => $item['productName'],
        'QUANTITY' => $item['sl'],
        'PRICE' => $item['productPrice']
    ]);
}

// Xóa 
unset($_SESSION['cart']);

class OnlineCheckOut {

         public function execPostRequest($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

      public function online_checkout($totalPrice) {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán qua MoMo";
        //$amount = "10000";//$totalCounter
       $amount=$totalPrice;
       $orderId = time() . "";
       // $orderId = time() . "";
        $redirectUrl = "http://localhost:3000/CheckOutIndex.php";
        $ipnUrl = "http://localhost:3000/CheckOutIndex.php";
        $extraData = "";

        if (!empty($_POST)) {
            $requestId = time() . "";
            $requestType = "payWithATM";
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);
            var_dump($jsonResult);// thêm vào

            if (isset($jsonResult['payUrl'])) {
                header('Location: ' . $jsonResult['payUrl']);
            } else {
                echo 'Error: payUrl not found in response';
            }
        } else {
            echo 'Error: POST data is empty';
        }
        
    }
}

$checkout = new OnlineCheckOut();
$checkout->online_checkout($totalPrice);
?>

