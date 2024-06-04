<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: ./DN_DK/login.php');
    exit;
}
$pdo = new PDO('mysql:host=localhost;dbname=fastfood', 'root', '');

// Lấy user_id của người dùng từ session
$user = $_SESSION['user'];
$user_id = $user['USERID'];

// Xử lý khi người dùng nhấn nút "Update Address"
if (isset($_POST['add_address'])) {
    // Lấy thông tin địa chỉ từ form
    $province_id = $_POST['province'];
    $district_id = $_POST['district'];
    $wards_id = $_POST['wards'];

    // Thực hiện truy vấn để lấy thông tin của các option đã chọn
    $province_name = "";
    $district_name = "";
    $wards_name = "";

    $sql_province = "SELECT name FROM province WHERE province_id = :province_id";
    $stmt_province = $pdo->prepare($sql_province);
    $stmt_province->bindParam(':province_id', $province_id, PDO::PARAM_INT);
    $stmt_province->execute();
    $row_province = $stmt_province->fetch(PDO::FETCH_ASSOC);
    $province_name = $row_province['name'];

    $sql_district = "SELECT name FROM district WHERE district_id = :district_id";
    $stmt_district = $pdo->prepare($sql_district);
    $stmt_district->bindParam(':district_id', $district_id, PDO::PARAM_INT);
    $stmt_district->execute();
    $row_district = $stmt_district->fetch(PDO::FETCH_ASSOC);
    $district_name = $row_district['name'];

    $sql_wards = "SELECT name FROM wards WHERE wards_id = :wards_id";
    $stmt_wards = $pdo->prepare($sql_wards);
    $stmt_wards->bindParam(':wards_id', $wards_id, PDO::PARAM_INT);
    $stmt_wards->execute();
    $row_wards = $stmt_wards->fetch(PDO::FETCH_ASSOC);
    $wards_name = $row_wards['name'];

    // Tạo địa chỉ từ thông tin đã lấy
    $address = $wards_name . ", " . $district_name . ", " . $province_name;

    // Thực hiện cập nhật USERADDRESS trong bảng users
    $sql_update = "UPDATE users SET USERADDRESS = :address WHERE USERID = :user_id";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
    if ($stmt_update->execute()) {
        $_SESSION['address_update_success'] = "Cập nhật địa chỉ thành công!";
    } else {
        $_SESSION['address_update_success'] = "Có lỗi xảy ra khi cập nhật địa chỉ!";
    }
    header('Location: ShowCart.php');
    exit;
}

?>
