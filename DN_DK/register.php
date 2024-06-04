<?php
session_start();

function postIndex($index, $value = "") {
    return isset($_POST[$index]) ? $_POST[$index] : $value;
}

$sm = postIndex("submit");
$ten = postIndex("ten");
$matkhau = postIndex("matkhau");
$nhaplaimatkhau = postIndex("nhaplaimatkhau");
$email = postIndex("email");
$birth = postIndex("birth");
$province_id = postIndex("province");

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //  xử lý lỗi 
    if (empty($ten)) {
        $errors['ten'] = "Phải nhập tên đăng nhập";
    }
    if (empty($matkhau)) {
        $errors['matkhau'] = "Phải nhập mật khẩu";
    }
    if (empty($nhaplaimatkhau)) {
        $errors['nhaplaimatkhau'] = "Phải nhập lại mật khẩu";
    } elseif ($nhaplaimatkhau != $matkhau) {
        $errors['nhaplaimatkhau'] = "Mật khẩu nhập lại không đúng";
    }
    if (empty($email)) {
        $errors['email'] = "Phải nhập email";
    }

    if ($_FILES["hinhdaidien"]["error"] !== UPLOAD_ERR_OK) {
        $errors['hinhdaidien'] = "Vui lòng chọn hình đại diện";
    } else {
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
        $detectedType = exif_imagetype($_FILES["hinhdaidien"]["tmp_name"]);
        if (!in_array($detectedType, $allowedTypes)) {
            $errors['hinhdaidien'] = "Hình đại diện phải là file .jpg hoặc .png";
        }
    }

    // Kiểm tra xem email có tồn tại 
    if (empty($errors)) {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=fastfood', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("SELECT * FROM users WHERE EMAIL = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $errors['email'] = "Email đã tồn tại trong hệ thống.";
            } else {
                $role_id = (isset($_POST['vaitro']) && $_POST['vaitro'] == '1') ? 1 : 2;
                $hashed_password = ($matkhau);
                
                // Lấy tên tỉnh/thành phố
                $stmt = $pdo->prepare("SELECT name FROM province WHERE province_id = ?");
                $stmt->execute([$province_id]);
                $province_name = $stmt->fetchColumn();

                $query = $pdo->prepare("INSERT INTO USERS (FULLNAME, USERPASSWORD, EMAIL, DAYOFBIRTH, USERADDRESS, PICTURE, ROLEID, province_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $query->execute([$ten, $hashed_password, $email, $birth, $province_name, $_FILES["hinhdaidien"]["name"], $role_id, $province_id]);
                $_SESSION['email'] = $email; // gán session email để lm quên pass
                header("location: login.html");
                exit;
            }
        } catch (PDOException $e) {
            $errors['database'] = "Lỗi khi lưu vào CSDL: " . $e->getMessage();
        }
    }
}

// Reset 
if (isset($_POST['reset'])) {
    $ten = "";
    $matkhau = "";
    $nhaplaimatkhau = "";
    $email = "";
    $hinhdaidien = "";
}
// -------------- dia chi----------
try {
    $pdo = new PDO('mysql:host=localhost;dbname=fastfood', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM province";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['add_sale'])) {
    echo "<pre>";
    print_r($_POST);
    die();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="dn_dk.css" rel="stylesheet" type="text/css">
    <link href="templatemo_style.css" rel="stylesheet" type="text/css">
    <title>Đăng Ký</title>
</head>
<body>

<fieldset>
    <legend>Nhập thông tin đăng ký</legend>
    <form action="register.php" method="post" enctype="multipart/form-data">
        <table align="center">
            <tr>
                <td><label for="ten">Tên đăng nhập:</label></td>
                <td><input type="text" id="ten" name="ten"><?php if (!empty($errors['ten'])) echo "<span style='color: red;'>{$errors['ten']}</span>"; ?></td>
            </tr>
            <tr>
                <td><label for="matkhau">Mật khẩu:</label></td>
                <td><input type="password" id="matkhau" name="matkhau"><?php if (!empty($errors['matkhau'])) echo "<span style='color: red;'>{$errors['matkhau']}</span>"; ?></td>
            </tr>
            <tr>
                <td><label for="nhaplaimatkhau">Nhập lại mật khẩu:</label></td>
                <td><input type="password" id="nhaplaimatkhau" name="nhaplaimatkhau"><?php if (!empty($errors['nhaplaimatkhau'])) echo "<span style='color: red;'>{$errors['nhaplaimatkhau']}</span>"; ?></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="text" id="email" name="email"><?php if (!empty($errors['email'])) echo "<span style='color: red;'>{$errors['email']}</span>"; ?></td>
            </tr>
            <tr>
                <td><label for="province">Tỉnh/Thành phố:</label></td>
                <td>
                    <select id="province" name="province" class="form-control">
                    <option value="">Chọn một tỉnh</option>
                        <?php foreach ($result as $row): ?>
                            <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['province'])) echo "<span style='color: red;'>{$errors['province']}</span>"; ?>
                </td>
            </tr>
            <tr>
                <td><label for="hinhdaidien">Hình đại diện:</label></td>
                <td><input type="file" name="hinhdaidien" id="hinhdaidien"><?php if (!empty($errors['hinhdaidien'])) echo "<span style='color: red;'>{$errors['hinhdaidien']}</span>"; ?></td>
            </tr>
            <tr>
                <td><label for="vaitro">Vai trò:</label></td>
                <td>
                    <label><input type="radio" id="user" name="vaitro" value="2" checked> Người dùng (User)</label><br>
                    <label><input type="radio" id="admin" name="vaitro" value="1"> Quản trị viên (Admin)</label>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button type="submit" name="submit">Đăng ký</button>
                    <input type="reset" name="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>

    <?php if (!empty($errors['database'])) : ?>
        <div style="color: red; text-align: center;"><?php echo $errors['database']; ?></div>
    <?php endif; ?>

 </fieldset>
        
</body>
</html>
