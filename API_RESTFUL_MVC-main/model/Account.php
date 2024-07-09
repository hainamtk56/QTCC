<?php
class Account
{
    private $conn;
    public $id_account;
    public $user_account;
    public $pass_account;
    public $type_account;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read data
    public function read()
    {
        $query = "SELECT * FROM accounts ORDER BY id_account ASC ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // show data
    public function show()
    {
        $query = "SELECT * FROM accounts WHERE id_account = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_account);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra xem có bản ghi nào được trả về không
        if ($stmt->rowCount() > 0) {
            // Nếu có bản ghi, lấy thông tin và gán vào các thuộc tính
            $this->user_account = $row['user_account'];
            $this->pass_account = $row['pass_account'];
            $this->type_account = $row['type_account'];
        } else {
            // Nếu không có bản ghi nào được tìm thấy, trả về một thông báo lỗi
            return array('message' => 'No record found for ID: ' . $this->user_account);
        }
    }

    // create data
    public function create()
    {
        $query = "INSERT INTO accounts SET user_account=:user_account,pass_account=:pass_account,type_account=:type_account";
        $stmt = $this->conn->prepare($query);

        //clearn data
        $this->user_account = htmlspecialchars(strip_tags($this->user_account));
        $this->pass_account = htmlspecialchars(strip_tags($this->pass_account));
        $this->type_account = htmlspecialchars(strip_tags($this->type_account));

        //ket hop 
        $stmt->bindParam(':user_account', $this->user_account);
        $stmt->bindParam(':pass_account', $this->pass_account);
        $stmt->bindParam(':type_account', $this->type_account);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }

    public function update()
    {
        $query = "UPDATE accounts SET user_account=:user_account,pass_account=:pass_account,type_account=:type_account WHERE id_account=:id_account";
        $stmt = $this->conn->prepare($query);

        //clearn data
        $this->user_account = htmlspecialchars(strip_tags($this->user_account));
        $this->pass_account = htmlspecialchars(strip_tags($this->pass_account));
        $this->type_account = htmlspecialchars(strip_tags($this->type_account));
        $this->id_account = htmlspecialchars(strip_tags($this->id_account));

        //ket hop 
        $stmt->bindParam(':user_account', $this->user_account);
        $stmt->bindParam(':pass_account', $this->pass_account);
        $stmt->bindParam(':type_account', $this->type_account);
        $stmt->bindParam(':id_account', $this->id_account);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM accounts WHERE id_account=:id_account";
        $stmt = $this->conn->prepare($query);

        $this->id_account = htmlspecialchars(strip_tags($this->id_account));
        $stmt->bindParam(':id_account', $this->id_account);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }

    // Phương thức tìm kiếm tài khoản
    public function search($keyword)
    {
        // Tạo truy vấn SQL để tìm kiếm tài khoản theo từ khóa
        $query = "SELECT * FROM accounts WHERE user_account LIKE :keyword OR type_account LIKE :keyword";

        // Chuẩn bị truy vấn
        $stmt = $this->conn->prepare($query);

        // Gán giá trị cho tham số
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword);

        // Thực hiện truy vấn
        $stmt->execute();

        // Kiểm tra xem có kết quả tìm kiếm không
        if ($stmt->rowCount() > 0) {
            // Lấy tất cả các bản ghi tìm thấy
            $accounts = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $account_item = array(
                    'id_account' => $row['id_account'],
                    'user_account' => $row['user_account'],
                    'pass_account' => $row['pass_account'],
                    'type_account' => $row['type_account']
                );
                // Thêm tài khoản vào mảng kết quả
                array_push($accounts, $account_item);
            }
            return $accounts;
        } else {
            // Trả về thông báo nếu không tìm thấy kết quả
            return array('message' => 'No records found for keyword: ' . $keyword);
        }
    }

    public function isDuplicate()
    {
        // Query to check if the user_account already exists
        $query = "SELECT id_account FROM accounts WHERE user_account = :user_account";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameter
        $stmt->bindParam(':user_account', $this->user_account);

        // Execute query
        $stmt->execute();

        // Check if any row exists
        if ($stmt->rowCount() > 0) {
            return true; // Duplicate account exists
        } else {
            return false; // No duplicate account
        }
    }
}
