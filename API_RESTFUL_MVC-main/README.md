# RESTful API Ký túc xá UTT theo mô hình MVC
<h1> Database Connection </h1>

> <p> Đường dẫn của file kết nối Database => ../config/db.php </p>

<p> Cấu hình file db.php </p>

```php
<?php
class db
{
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $db = "api_resful_kytucxa";
    private $conn;

    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->db, $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfull";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
```
