<?php

class AdminController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $sql = 'SELECT * FROM orderdetail';
        return $this->db->selectQuery($sql);
    }

    public function ViewProduct() {
        $sql = 'SELECT * FROM products';
        return $this->db->selectQuery($sql);
    }
    //
    function GetNameProduct($id) {
        $sql = "SELECT PRODUCTNAME FROM products WHERE PRODUCTID =?";
        return $this->db->selectQuery($sql, [$id]);
    }

    function DeletedProduct($id)  {
        $sql = "delete from products where PRODUCTID=?";
        return $this->db->updateQuery($sql, [$id]);
    }

    function SelectTypeProduct() {
        $sql = 'SELECT * FROM producttype';
        return $this->db->selectQuery($sql);
    }

    //Add Product
    function AddProduct($productName, $description, $price, $img, $created_at, $pro_type_id) {
        $sql = "INSERT INTO products(PRODUCTNAME, PRODUCTDESCRIPTION, PRICE, PICTURE, CREATED_AT_OF_PROD, PROD_TYPE_ID)VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->updateQuery($sql, [$productName, $description, $price, $img, $created_at, $pro_type_id]);
    }
    //Update Product

    public function GetProduct($id) {
        $sql = 'SELECT * FROM products WHERE PRODUCTID = :id';
        $params = array(':id' => $id);
        return $this->db->selectQuery($sql, $params);
    }
    
    public function UpdateProduct($id, $name, $description, $price, $picture, $updated_at, $type) {
   
        $vietnam_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $updated_at = $vietnam_time->format('Y-m-d');

        $sql = "UPDATE products 
                SET PRODUCTNAME = :name, 
                    PRODUCTDESCRIPTION = :description, 
                    PRICE = :price, 
                    PICTURE = :picture, 
                    UPDATED_AT_OF_PROD = :updated_at, 
                    PROD_TYPE_ID = :type 
                WHERE PRODUCTID = :id";
        
        // Prepare the parameters for the query
        $params = array(
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':picture' => $picture,
            ':type' => $type,
            ':updated_at' => $updated_at,
            ':id' => $id
        );
    
        // Execute the update query
        return $this->db->updateQuery($sql, $params);
    }
    

    public function ViewCustomers() {
        $sql = 'SELECT * FROM users WHERE ROLEID=2';
        return $this->db->selectQuery($sql);
    }

    function Delete_Customer($id)  {
        $sql = "delete from users where USERID=?";
        return $this->db->updateQuery($sql, [$id]);
    }

    function GetNameProductType($id) {
        $sql = "SELECT PROD_TYPE_NAME FROM producttype WHERE PROD_TYPE_ID =?";
        return $this->db->selectQuery($sql, [$id]);
    }
        //////

    public function getUserByID($id) {
        $sql = "SELECT * FROM users WHERE USERID = :id";
    
        $params = array(':id' => $id);
    
       return $this->db->selectQuery($sql, $params);
        
    }
        

    //Update password
    public function updatePassword($id, $newPassword) {
        $stmt = $this->db->prepare("UPDATE users SET USERPASSWORD = :password WHERE USERID = :id");
        return $stmt->execute([':password' => $newPassword, ':id' => $id]);
    }

    ///

    public function updateUserDetails($user_id, $fullname, $phone, $email, $dayofbirth, $address, $picture) {
        try {
            // Prepare the SQL statement
            $stmt = $this->db->prepare("UPDATE users SET FULLNAME = ?, PHONE = ?, EMAIL = ?, DAYOFBIRTH = ?,USERADDRESS = ?, PICTURE = ? WHERE USERID = ?");
            
            // Bind parameters
            $stmt->bindParam(1, $fullname);
            $stmt->bindParam(2, $phone);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $dayofbirth);
            $stmt->bindParam(5, $address);
            $stmt->bindParam(6, $picture);
            $stmt->bindParam(7, $user_id);
            
            // Execute the statement
            $stmt->execute();
            
            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                // User details updated successfully
                return true;
            } else {
                // No rows affected, possibly user ID not found
                return false;
            }
        } catch (PDOException $e) {
            // Handle any database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}


?>