<?php


class DB {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function selectQuery($sql, $params = []) {
        $stm = $this->conn->prepare($sql);
        $stm->execute($params);
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateQuery($sql, $params = []) {
        $stm = $this->conn->prepare($sql);
        $stm->execute($params);
        return $stm->rowCount();
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }
}
?>



    