<?php
if (!defined('FILTER_FLAG_HOST_REQUIRED')) {
    define('FILTER_FLAG_HOST_REQUIRED', 0);
}
include "PHPMailer/src/PHPMailer.php";
include "PHPMailer/src/Exception.php";
include "PHPMailer/src/OAuth.php";
include "PHPMailer/src/POP3.php";
include "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public function dathangmail($tieude, $noidung, $maildathang) {
        $mail = new PHPMailer(true);  
        $mail->CharSet = 'UTF-8';

        try {
            // Cài đặt máy chủ
            $mail->SMTPDebug = 0;                                 
            $mail->isSMTP();                                      // Thiết lập gửi mail sử dụng SMTP
            $mail->Host = 'smtp.gmail.com';                       // Chỉ định máy chủ SMTP chính và dự phòng
            $mail->SMTPAuth = true;                               // Kích hoạt xác thực SMTP
            $mail->Username = 'thanhthuy0983860756@gmail.com';             // Tên đăng nhập SMTP
            $mail->Password = 'ywhrhmdrccwyzhxr';             // Mật khẩu SMTP
            $mail->SMTPSecure = 'tls';                            // Kích hoạt mã hóa TLS, cũng chấp nhận `ssl`
            $mail->Port = 587;                                    // Cổng TCP để kết nối
        
            // Người nhận
            $mail->setFrom('thanhthuy0983860756@gmail.com', 'FastFood');
            $mail->addAddress($maildathang, 'Customer');          // Thêm một người nhận
            $mail->addCC('thanhthuy0983860756@gmail.com');
        
            // Nội dung
            $mail->isHTML(true);                                  // Thiết lập định dạng email là HTML
            $mail->Subject = $tieude;
            $mail->Body    = $noidung;
        
            $mail->send();
            echo 'Tin nhắn đã được gửi qua Email';
        } catch (Exception $e) {
            echo 'Tin nhắn không thể được gửi. Lỗi Mailer: ', $mail->ErrorInfo;
        }
    }
}
?>
