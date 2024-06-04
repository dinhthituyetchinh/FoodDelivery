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

    if(isset($_POST["u_fullname"]) || isset( $_POST["u_phone"]) || isset($_POST["u_email"]) || isset( $_POST["u_dayofbirth"]) || isset($_POST["u_address"]))
    {
        $fullname = $_POST["u_fullname"];
    $phone = $_POST["u_phone"];
    $email = $_POST["u_email"];
    $dayofbirth = $_POST["u_dayofbirth"];
    $address = $_POST["u_address"];
    $old_picture = $u[0]->PICTURE; // Store the old picture URL

    // Check if a new picture has been uploaded
    if (isset($_FILES["u_img"]) && $_FILES["u_img"]["error"] == UPLOAD_ERR_OK) {
        // Handle uploaded picture
        $new_picture = handle_uploaded_picture(); // You need to implement this function
    } else {
        // Keep the old picture
        $new_picture = $old_picture;
    }

    // Update user details in the database
    $success = $model->updateUserDetails($u_id, $fullname, $phone, $email, $dayofbirth, $address, $new_picture);

    // Provide feedback to the user
    if ($success) {
        ?>
            
        <script>
            alert('Cập nhật thành công');
            window.location = 'ViewAdmin.php';
        </script>     
        <?php
         exit;
    } else {
        ?>
            
        <script>
            alert('Cập nhật không thành công');
            window.location = 'ViewAdmin.php';
        </script>     
        <?php
         exit;
    }
    }

    function handle_uploaded_picture() {
        // Check if the file upload is successful
        if ($_FILES["u_img"]["error"] != UPLOAD_ERR_OK) {
            // Handle the upload error
            echo "Error uploading file.";
            return false;
        }
        
        // Define the directory where the uploaded picture will be stored
        $upload_dir = "../hinh/"; // You need to create this directory if it doesn't exist
        
        // Generate a unique filename to prevent overwriting existing files
        $new_filename = uniqid() . "_" . basename($_FILES["u_img"]["name"]);
        
        // Define the path where the uploaded picture will be stored
        $target_path = $upload_dir . $new_filename;
        
        // Check if the file type is allowed (you can adjust the allowed file types as needed)
        $allowed_types = array("image/jpeg", "image/png", "image/gif");
        if (!in_array($_FILES["u_img"]["type"], $allowed_types)) {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
            return false;
        }
        
        // Check if the file size is within the limit (you can adjust the file size limit as needed)
        if ($_FILES["u_img"]["size"] > 800000) {
            echo "File size exceeds the limit. Maximum size allowed is 800KB.";
            return false;
        }
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["u_img"]["tmp_name"], $target_path)) {
            // File upload successful, return the URL of the uploaded picture
            return $target_path;
        } else {
            // Handle the upload failure
            echo "Error moving file to destination directory.";
            return false;
        }
    }
?>

<style>

    .ui-w-80 {
        width: 80px !important;
        height: auto;
    }

    .btn-default {
        border-color: rgba(24,28,33,0.1);
        background: rgba(0,0,0,0);
        color: #4E5155;
    }

    label.btn {
        margin-bottom: 0;
    }

    .btn-outline-primary {
        border-color: #26B4FF;
        background: transparent;
        color: #26B4FF;
    }

    .btn {
        cursor: pointer;
    }

    .text-light {
        color: #babbbc !important;
    }

    .btn-facebook {
        border-color: rgba(0,0,0,0);
        background: #3B5998;
        color: #fff;
    }

    .btn-instagram {
        border-color: rgba(0,0,0,0);
        background: #000;
        color: #fff;
    }

    .card {
        background-clip: padding-box;
        box-shadow: 0 1px 4px rgba(24,28,33,0.012);
    }

    .row-bordered {
        overflow: hidden;
    }

    .account-settings-fileinput {
        position: absolute;
        visibility: hidden;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .account-settings-links .list-group-item.active {
        font-weight: bold !important;
    }

    html:not(.dark-style) .account-settings-links .list-group-item.active {
        background: transparent !important;
    }

    .account-settings-multiselect ~ .select2-container {
        width: 100% !important;
    }

    .light-style .account-settings-links .list-group-item {
        padding: 0.85rem 1.5rem;
        border-color: rgba(24, 28, 33, 0.03) !important;
    }

        .light-style .account-settings-links .list-group-item.active {
            color: #4e5155 !important;
        }

    .material-style .account-settings-links .list-group-item {
        padding: 0.85rem 1.5rem;
        border-color: rgba(24, 28, 33, 0.03) !important;
    }

        .material-style .account-settings-links .list-group-item.active {
            color: #4e5155 !important;
        }

    .dark-style .account-settings-links .list-group-item {
        padding: 0.85rem 1.5rem;
        border-color: rgba(255, 255, 255, 0.03) !important;
    }

        .dark-style .account-settings-links .list-group-item.active {
            color: #fff !important;
        }

    .light-style .account-settings-links .list-group-item.active {
        color: #4E5155 !important;
    }

    .light-style .account-settings-links .list-group-item {
        padding: 0.85rem 1.5rem;
        border-color: rgba(24,28,33,0.03) !important;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<h2 class="text-center">ACCOUNT DETAILS</h2>
<form method="post" action="" enctype="multipart/form-data">
    <div class="container light-style flex-grow-1 container-p-y p-3">

        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>

        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="./ViewAdmin.php">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="./ViewResetPassword.php">Change password</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">

                            <div class="card-body media align-items-center">
                                <img src="<?php echo $u[0]->PICTURE  ?>" alt="" class="d-block ui-w-80" >
                                <div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">
                                        Upload new photo
                                        <input type="file" class="account-settings-fileinput" name="u_img">
                                    </label> &nbsp;
                                    <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            <hr class="border-light m-0">

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Full name</label>
                                    <input type="text" class="form-control mb-1" value="<?php echo $u[0]->FULLNAME  ?>" name="u_fullname">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" value="<?php echo $u[0]->PHONE  ?>" name="u_phone">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" class="form-control mb-1" value="<?php echo $u[0]->EMAIL ?>" name="u_email">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Day Of Birth</label>
                                    <input type="date" class="form-control" value="<?php echo $u[0]->DAYOFBIRTH ?>" name="u_dayofbirth">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control mb-1" value="<?php echo $u[0]->USERADDRESS ?>" name="u_address">
                                </div>
                            </div>

                        </div>                  

        <div class="text-right mt-3 mb-3 p-4">
            <button type="submit" class="btn btn-danger">Save changes</button>&nbsp;
        </div>

    </div>
</form>


<?php
    
?>