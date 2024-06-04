<?php
session_start();
include '../config.php';  
include '../mail/sendmail.php';
$success = false;
if(isset($_POST['submit'])){
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Kiểm tra xem email 
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {

       
        $stmt = $conn->prepare("SELECT * FROM users WHERE EMAIL = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra xem email có tồn tại trong csdl
        if ($user) {
            $userId = $user['USERID'];
            $userPassword = $user['USERPASSWORD'];

           //------- gui mail
            $tieude = "Yêu cầu lấy lại mật khẩu";
            $noidung = "<p>Đăng nhập tài khoản website chinh2thuy.infinityfreeapp.com.</p>";
            $noidung = "<h4>Mật khẩu của bạn là: $userPassword</h4>";

            $mailer = new Mailer();
            $mailer->dathangmail($tieude, $noidung, $email);
            $success = true;

        } else {
            echo "Không tìm thấy địa chỉ email trong cơ sở dữ liệu.";
        }
    } else {
        echo "Vui lòng nhập địa chỉ email hợp lệ.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="dn_dk.css" rel="stylesheet" type="text/css">
    <title>Quên Mật Khẩu</title>
    <link href="templatemo_style.css" rel="stylesheet" type="text/css">
    <script>
        function resetForm() {
            document.getElementById('forgotPasswordForm').reset();
        }
        function showSuccessMessage() {
            document.getElementById('successMessage').style.display = 'block';
            setTimeout(function(){
                document.getElementById('successMessage').style.display = 'none';
            }, 3000); 
        }
    </script>
</head>
<body>
    <fieldset>
        <legend>Quên Mật Khẩu</legend>
        <form id="forgotPasswordForm" action="forgotpass.php" method="post" enctype="multipart/form-data">
            <table align="center">
                <tr>
                    <td><label>Email:</label></td>
                    <td width="250px"><input type="text" name="email"></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><button type="submit" name="submit">Gửi Mật Khẩu</button></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        Bạn đã nhớ mật khẩu? <a href="login.html">Đăng nhập!</a>
                    </td>
                </tr>
            </table>
        </form>
        <?php if ($success) { ?>
            <p id="successMessage" style="color: green; display: none;">Mật khẩu đã được gửi về địa chỉ email của bạn.</p>
            <script>
                showSuccessMessage();
                resetForm(); 
            </script>
        <?php } ?>
    </fieldset>
</body>
</html>
