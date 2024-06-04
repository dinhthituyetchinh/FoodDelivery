<?php
//if (!defined('BASEPATH')) {
 //   define('BASEPATH', true) OR exit('No direct script access allowed');
//}

require_once __DIR__ . '/Xuly/IndexModel.php';

class CheckOutIndex {
    private $IndexModel;

    public function __construct() {
        $this->IndexModel = new IndexModel();
    }

    public function thanks() {
        $pageTitle = 'Thanks đã mua hàng';
        if (isset($_GET['partnerCode'])) {
            $data_momo = [
                'partnerCode' => $_GET['partnerCode'],
                'orderId' => $_GET['orderId'],
                'requestId' => $_GET['requestId'],
                'amount' => $_GET['amount'],
                'orderInfo' => $_GET['orderInfo'],
                'orderType' => $_GET['orderType'],
                'transId' => $_GET['transId'],
                'payType' => $_GET['payType'],
                'signature' => $_GET['signature']
            ];

            error_log("Attempting to insert data: " . print_r($data_momo, true));

            $result = $this->IndexModel->insertMoMo($data_momo);
            if ($result) {
                error_log("Data inserted successfully");
                echo "Data inserted successfully";
            } else {
                error_log("Failed to insert data");
                echo "Failed to insert data";
            }
        } else {
            error_log("partnerCode is not set in the request");
        }
        $this->loadView(__DIR__ . '/Xuly/thanks', compact('pageTitle'));
    }

    protected function loadView($view, $data = []) {
        extract($data);
        require_once($view . '.php');
    }
}

$checkout = new CheckOutIndex();
$checkout->thanks();
?>
