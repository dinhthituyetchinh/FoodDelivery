<?php 
require 'config.php';

$province_id = isset($_GET['province_id']) ? intval($_GET['province_id']) : 0;

try {
    $sql = "SELECT * FROM `district` WHERE `province_id` = :province_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':province_id', $province_id, PDO::PARAM_INT);
    $stmt->execute();

    $data = [
        ['id' => null, 'name' => 'Chọn một Quận/huyện']
    ];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'id' => $row['district_id'],
            'name' => $row['name']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
