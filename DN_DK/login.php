<?php
session_start();

$errors = array();
$u = isset($_POST['ten']) ? $_POST['ten'] : '';
$p = isset($_POST['matkhau']) ? $_POST['matkhau'] : '';

if ($u == '') {
    $errors['ten_error'] = "Phải nhập tên đăng nhập";
}
if ($p == '') {
    $errors['matkhau_error'] = "Phải nhập mật khẩu";
}

if (empty($errors)) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=fastfood', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT u.*, r.ROLENAME 
                            FROM users u
                            JOIN roles r ON u.ROLEID = r.ROLEID
                            WHERE u.FULLNAME = :FULLNAME"); // Tìm người dùng dựa trên tên đăng nhập (FULLNAME)
        $stmt->execute(['FULLNAME' => $u]);

        $user = $stmt->fetch();

        if ($user && ($p) == $user['USERPASSWORD']) {
            $_SESSION['user'] = $user;
            $_SESSION['email'] = $user['EMAIL'];// để làm bên quên pass
            if ($user['ROLENAME'] == 'Admin') {
                $_SESSION['user_id'] = $user['USERID']; // Lưu USERID vào session
                header('location: ../admin/index.php'); //  Admin
                exit;
            } else {
                $_SESSION['user_id'] = $user['USERID']; // Lưu USERID vào session
                header('Location: ../index.php'); //  User
                exit;
            }
        } else {
            $errors['login'] = "Tên đăng nhập hoặc mật khẩu không đúng";
        }
    } catch (PDOException $e) {
        $errors['database'] = "Lỗi khi truy vấn CSDL: " . $e->getMessage();
    }
}

if (!empty($errors)) {
    header('Location:login.html');
    exit;
}


