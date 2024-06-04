<?php
session_start();
include 'config.php';

function thembinhluan($name, $iduser, $idsp, $noidung)
{
    global $conn; 
    $sql = "INSERT INTO comment (NAME, USERID, PRODUCTID, NOIDUNG) VALUES ('$name','$iduser','$idsp','$noidung')";
    $conn->exec($sql);
}

function showbl()
{
    global $conn; 
    $sql = "SELECT * FROM comment ORDER BY ID DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
}

if (isset($_SESSION['user']) && ($_SESSION['user']['USERID'] > 0)) {
    if (isset($_SESSION['user']['FULLNAME']) && ($_SESSION['user']['FULLNAME'] != "")) {
        $user = $_SESSION['user']['FULLNAME'];
    } else {
        $user = "";
    }
    if (isset($_POST['guibinhluan']) && ($_POST['guibinhluan'])) {
        $name = $_POST['NAME']; 
        $noidung = $_POST['NOIDUNG'];
        $idsp = $_POST['PRODUCTID'];
        $iduser = $_SESSION['user']['USERID'];
        try {
            thembinhluan($name, $iduser, $idsp, $noidung);
            $_SESSION['comment_success'] = true;
        } catch (Exception $e) {
            $_SESSION['comment_success'] = false;
        }
        header("Location: XemChiTiet.php?id=$idsp");
        exit();
    }
    $dsbl = showbl();
} else {
    echo "<a href='./DN_DK/login.php' target='_parent'>Bạn vui lòng đăng nhập!</a>";
}
?>
