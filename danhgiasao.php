<?php
session_start();
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ yêu cầu POST
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $productID = isset($_POST['PRODUCTID']) ? intval($_POST['PRODUCTID']) : 0;

    if ($rating > 0 && $productID > 0) {
        try {
          
            $sql = "INSERT INTO danhgiasao (PRODUCTID, rating) VALUES (:productID, :rating)";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':productID', $productID, PDO::PARAM_INT);
            $stm->bindParam(':rating', $rating, PDO::PARAM_INT);
            
            $stm->execute();

            echo json_encode(['status' => 'success', 'message' => 'Rating saved successfully!']);
        } catch (Exception $e) {
            
            echo json_encode(['status' => 'error', 'message' => 'Error saving rating: ' . $e->getMessage()]);
        }
    } else {
        
        echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
    }
} else {
    // Không phải là yêu cầu POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}


?>
