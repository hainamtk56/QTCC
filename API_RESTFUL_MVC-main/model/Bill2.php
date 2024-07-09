<?php
class Bill2
{
    private $conn;

    public $MaPhong;
    public $MaKhu;
    public $SoNguoiHienTai;
    public $SoNguoiToiDa;
    public $Gia;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    //read data
    public function read()
    {
        $query = "SELECT * FROM phong ORDER BY MaPhong ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Phương thức tìm kiếm sinh viên theo ID
    public function searchByMaPhong($MaPhong)
    {
        // Chuẩn bị truy vấn SQL để tìm kiếm sinh viên theo ID
        $query = "SELECT * FROM phong WHERE MaPHong LIKE :MaPhong";

        // Chuẩn bị câu lệnh SQL và thực hiện truy vấn
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':MaPhong', '%' . $MaPhong . '%', PDO::PARAM_STR); // Sử dụng PDO::PARAM_INT để chỉ định kiểu dữ liệu của tham số là integer
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Kiểm tra xem có bản ghi nào được trả về không
        if (!empty($result)) {
            // Nếu có, trả về dữ liệu sinh viên
            return $result;
        } else {
            // Nếu không tìm thấy sinh viên, trả về null
            return null;
        }
    }
}
