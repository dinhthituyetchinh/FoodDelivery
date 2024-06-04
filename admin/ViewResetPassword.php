<?php
    session_start();

    require "./header.php";
    require "../config.php";
    function loadClass($c)
    {
        include "../class/$c.php";
    }
    spl_autoload_register('loadClass');
    

    $u_id = $_SESSION["user_id"];
    $model = new AdminController(new DB(new PDO("mysql:host=$servername;dbname=$dbname", $username, $password)));
    $u = $model->getUserByID($u_id);
  
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <div class="mainAdd">
            <h3 class="text-center text-danger">Reset Password</h3>
        <div>
            <form method="post" action="">
                <input type="hidden" name="userID" value="<?php echo $u[0]->USERID ?>" />
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="fullName" name="" value="<?php echo $u[0]->FULLNAME  ?>" readlink>
                    <label for="fullName">Full Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="phone" name="" value="<?php echo $u[0]->PHONE  ?>" readonly>
                    <label for="phone">Phone</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" name="" value="<?php echo $u[0]->EMAIL ?>" readonly>
                    <label for="floatingInput">Email address</label>

                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="" name="newPassword">

                    <label for="floatingPassword">New Password</label>

                </div>
                <div class="form-floating mb-3">
        
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword">

                    <label for="confirmPassword">Confirm Password</label>

                </div>

                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" class="btn btn-danger justify-content-lg-between">UPDATES PASSWORD</button>
                </div>

            </form>
</div>
    </div>   

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userID = $_POST['userID'];
        $newPassword = trim($_POST['newPassword']);
        $confirmPassword = trim($_POST['confirmPassword']);

    
        if($newPassword == "" || $confirmPassword == "" )
        {
            
            ?>
                <p class="text-danger">Bạn phải nhập dữ liệu</p>
            <?php
            return;
            exit;
        }
        if (strlen($newPassword) < 6) {
                ?>
                <p class="text-danger">Bạn phải nhập từ 6 ký tự trở lên</p>
            <?php
            return;
            exit;
        }
        if ($newPassword !== $confirmPassword) {
            echo $newPassword;
            echo "ccccccc:".$confirmPassword;
            ?>
                <p class="text-danger">Mật khẩu không khớp</p>
            <?php
            return;
            exit;
        }
        if ($model->updatePassword($userID, $newPassword)) {
            ?>
            
            <script>
                alert('Đổi mật khẩu thành công');
                window.location = 'ViewResetPassword.php';
            </script>     
            <?php
             exit;
        } else {
            ?>
            
        <script>
            alert('Đổi mật khẩu không thành công');
            window.location = 'ViewResetPassword.php';
        </script>     
        <?php
         exit;
        }
    }
?>
