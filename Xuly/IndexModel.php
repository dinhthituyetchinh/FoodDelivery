<?php
//if (!defined('BASEPATH')) {
//   define('BASEPATH', true) OR exit('No direct script access allowed');
//}

class IndexModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'fastfood');
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function insertMoMo($data_momo) {
        $stmt = $this->db->prepare("INSERT INTO momo (partnerCode, orderId, requestId, amount, orderInfo, orderType, transId, payType, signature) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            die("Prepare failed: (" . $this->db->errno . ") " . $this->db->error);
        }

        $stmt->bind_param(
            "sssssssss",
            $data_momo['partnerCode'],
            $data_momo['orderId'],
            $data_momo['requestId'],
            $data_momo['amount'],
            $data_momo['orderInfo'],
            $data_momo['orderType'],
            $data_momo['transId'],
            $data_momo['payType'],
            $data_momo['signature']
        );

        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        } else {
            echo "Data inserted successfully";
        }

        $stmt->close();
    }
}
?>
