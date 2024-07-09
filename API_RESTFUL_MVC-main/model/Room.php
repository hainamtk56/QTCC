<?php
class Room
{
    private $conn;
    public $MaPhong;
    public $MaKhu;
    public $SoNguoiToiDa;
    public $SoNguoiHienTai;
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

    //show data
    public function show()
    {
        $query = "SELECT * FROM phong WHERE MaPhong = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaPhong);
        $stmt->execute();

        // Kiểm tra xem có bản ghi nào được trả về không
        if ($stmt->rowCount() > 0) {
            // Nếu có bản ghi, lấy thông tin và gán vào các thuộc tính
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->MaPhong = $row['MaPhong'];
            $this->MaKhu = $row['MaKhu'];
            $this->SoNguoiToiDa = $row['SoNguoiToiDa'];
            $this->SoNguoiHienTai = $row['SoNguoiHienTai'];
            $this->Gia = $row['Gia'];
        } else {
            // Nếu không có bản ghi nào được tìm thấy, trả về một thông báo lỗi
            return array('message' => 'No record found for MaPhong: ' . $this->MaPhong);
        }
    }

    //create data
    public function create()
    {
        $query = "INSERT INTO phong SET MaPhong=:MaPhong, MaKhu=:MaKhu, SoNguoiToiDa=:SoNguoiToiDa, SoNguoiHienTai=:SoNguoiHienTai, Gia=:Gia";

        $stmt = $this->conn->prepare($query);
        //clearn data
        $this->MaPhong = htmlspecialchars(strip_tags($this->MaPhong));
        $this->MaKhu = htmlspecialchars(strip_tags($this->MaKhu));
        $this->SoNguoiToiDa = htmlspecialchars(strip_tags($this->SoNguoiToiDa));
        $this->SoNguoiHienTai = htmlspecialchars(strip_tags($this->SoNguoiHienTai));
        $this->Gia = htmlspecialchars(strip_tags($this->Gia));
        //ket hop 
        $stmt->bindParam(':MaPhong', $this->MaPhong);
        $stmt->bindParam(':MaKhu', $this->MaKhu);
        $stmt->bindParam(':SoNguoiToiDa', $this->SoNguoiToiDa);
        $stmt->bindParam(':SoNguoiHienTai', $this->SoNguoiHienTai);
        $stmt->bindParam(':Gia', $this->Gia);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }

    //update data
    public function update()
    {
        $query = "UPDATE phong SET MaKhu=:MaKhu,SoNguoiToiDa=:SoNguoiToiDa,SoNguoiHienTai=:SoNguoiHienTai, Gia=:Gia WHERE MaPhong=:MaPhong";

        $stmt = $this->conn->prepare($query);
        //clearn data

        $this->MaKhu = htmlspecialchars(strip_tags($this->MaKhu));
        $this->SoNguoiToiDa = htmlspecialchars(strip_tags($this->SoNguoiToiDa));
        $this->SoNguoiHienTai = htmlspecialchars(strip_tags($this->SoNguoiHienTai));
        $this->Gia = htmlspecialchars(strip_tags($this->Gia));
        $this->MaPhong = htmlspecialchars(strip_tags($this->MaPhong));
        //ket hop 
        $stmt->bindParam(':MaKhu', $this->MaKhu);
        $stmt->bindParam(':SoNguoiToiDa', $this->SoNguoiToiDa);
        $stmt->bindParam(':SoNguoiHienTai', $this->SoNguoiHienTai);
        $stmt->bindParam(':Gia', $this->Gia);
        $stmt->bindParam(':MaPhong', $this->MaPhong);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }

    //delete
    public function delete()
    {
        $query = "DELETE FROM phong WHERE MaPhong = :MaPhong"; // Sửa thành MaPhong

        $stmt = $this->conn->prepare($query);

        $this->MaPhong = htmlspecialchars(strip_tags($this->MaPhong));
        $stmt->bindParam(':MaPhong', $this->MaPhong); // Sửa thành MaPhong

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }
    //search
    // Phương thức tìm kiếm sinh viên theo ID
    public function searchByMP($MaPhong)
    {
        // Chuẩn bị truy vấn SQL để tìm kiếm sinh viên theo ID
        $query = "SELECT * FROM phong WHERE MaPhong LIKE :MaPhong";

        // Chuẩn bị câu lệnh SQL và thực hiện truy vấn
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':MaPhong', '%' . $MaPhong . '%', PDO::PARAM_STR); // Sử dụng PDO::PARAM_STR để chỉ định kiểu dữ liệu của tham số là string
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
