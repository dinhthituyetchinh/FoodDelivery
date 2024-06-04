<?php 
require 'config.php';

$district_id = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;

try {
    $sql = "SELECT * FROM `wards` WHERE `district_id` = :district_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':district_id', $district_id, PDO::PARAM_INT);
    $stmt->execute();

    $data = [
        ['id' => null, 'name' => 'Chọn một xã/phường']
    ];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'id' => $row['wards_id'],
            'name' => $row['name']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
