<?php
class Student
{
    private $conn;

    public $MaSV;
    public $HoTen;
    public $NgaySinh;
    public $GioiTinh;
    public $DiaChi;
    public $SDT;
    public $Mail;
    public $MaPhong;
    public $TenKhu;
    public $user_account;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //read data
    public function read()
    {
        $query = "SELECT * FROM sinhvien ORDER BY MaSV ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //show data
    public function show()
    {
        $query = "SELECT * FROM sinhvien WHERE MaSV = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaSV);
        $stmt->execute();

        // Kiểm tra xem có bản ghi nào được trả về không
        if ($stmt->rowCount() > 0) {
            // Nếu có bản ghi, lấy thông tin và gán vào các thuộc tính
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->MaSV = $row['MaSV'];
            $this->HoTen = $row['HoTen'];
            $this->NgaySinh = $row['NgaySinh'];
            $this->GioiTinh = $row['GioiTinh'];
            $this->DiaChi = $row['DiaChi'];
            $this->SDT = $row['SDT'];
            $this->Mail = $row['Mail'];
            $this->MaPhong = $row['MaPhong'];
            $this->TenKhu = $row['TenKhu'];
            $this->user_account = $row['user_account'];
            return $row; // Trả về dữ liệu của sinh viên

        } else {
            // Nếu không có bản ghi nào được tìm thấy, trả về một thông báo lỗi
            return array('message' => 'No record found for MaSV: ' . $this->MaSV);
        }
    }

    //create data
    public function create()
    {
        $query = "INSERT INTO sinhvien 
            SET 
                MaSV=:MaSV,
                HoTen=:HoTen,
                NgaySinh=:NgaySinh,
                GioiTinh=:GioiTinh,
                DiaChi=:DiaChi,
                SDT=:SDT,
                Mail=:Mail,
                MaPhong=:MaPhong,
                TenKhu=:TenKhu,
                user_account=:user_account";

        $stmt = $this->conn->prepare($query);
        //clean data
        $this->MaSV = htmlspecialchars(strip_tags($this->MaSV));
        $this->HoTen = htmlspecialchars(strip_tags($this->HoTen));
        $this->NgaySinh = htmlspecialchars(strip_tags($this->NgaySinh));
        $this->GioiTinh = htmlspecialchars(strip_tags($this->GioiTinh));
        $this->DiaChi = htmlspecialchars(strip_tags($this->DiaChi));
        $this->SDT = htmlspecialchars(strip_tags($this->SDT));
        $this->Mail = htmlspecialchars(strip_tags($this->Mail));
        $this->MaPhong = htmlspecialchars(strip_tags($this->MaPhong));
        $this->TenKhu = htmlspecialchars(strip_tags($this->TenKhu));
        $this->user_account = htmlspecialchars(strip_tags($this->user_account));
        //bind parameters
        $stmt->bindParam(':MaSV', $this->MaSV);
        $stmt->bindParam(':HoTen', $this->HoTen);
        $stmt->bindParam(':NgaySinh', $this->NgaySinh);
        $stmt->bindParam(':GioiTinh', $this->GioiTinh);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
        $stmt->bindParam(':Mail', $this->Mail);
        $stmt->bindParam(':MaPhong', $this->MaPhong);
        $stmt->bindParam(':TenKhu', $this->TenKhu);
        $stmt->bindParam(':user_account', $this->user_account);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }


    //update data
    public function update()
    {
        $query = "UPDATE sinhvien SET 
                HoTen=:HoTen,
                NgaySinh=:NgaySinh,
                GioiTinh=:GioiTinh,
                DiaChi=:DiaChi,
                SDT=:SDT,
                Mail=:Mail,
                MaPhong=:MaPhong,
                TenKhu=:TenKhu,
                user_account=:user_account 
            WHERE MaSV=:MaSV";

        $stmt = $this->conn->prepare($query);
        //clean data
        $this->MaSV = htmlspecialchars(strip_tags($this->MaSV));
        $this->HoTen = htmlspecialchars(strip_tags($this->HoTen));
        $this->NgaySinh = htmlspecialchars(strip_tags($this->NgaySinh));
        $this->GioiTinh = htmlspecialchars(strip_tags($this->GioiTinh));
        $this->DiaChi = htmlspecialchars(strip_tags($this->DiaChi));
        $this->SDT = htmlspecialchars(strip_tags($this->SDT));
        $this->Mail = htmlspecialchars(strip_tags($this->Mail));
        $this->MaPhong = htmlspecialchars(strip_tags($this->MaPhong));
        $this->TenKhu = htmlspecialchars(strip_tags($this->TenKhu));
        $this->user_account = htmlspecialchars(strip_tags($this->user_account));
        //bind parameters
        $stmt->bindParam(':MaSV', $this->MaSV);
        $stmt->bindParam(':HoTen', $this->HoTen);
        $stmt->bindParam(':NgaySinh', $this->NgaySinh);
        $stmt->bindParam(':GioiTinh', $this->GioiTinh);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
        $stmt->bindParam(':Mail', $this->Mail);
        $stmt->bindParam(':MaPhong', $this->MaPhong);
        $stmt->bindParam(':TenKhu', $this->TenKhu);
        $stmt->bindParam(':user_account', $this->user_account);
        //execute query
        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }
    //delete data
    public function delete()
    {
        $query = "DELETE FROM sinhvien WHERE MaSV=:MaSV";

        $stmt = $this->conn->prepare($query);

        $this->MaSV = htmlspecialchars(strip_tags($this->MaSV));
        $stmt->bindParam(':MaSV', $this->MaSV);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }

    // Phương thức tìm kiếm sinh viên theo MaSV
    public function search($keyword)
    {
        // Chuẩn bị truy vấn SQL để tìm kiếm sinh viên theo MaSV
        $query = "SELECT * FROM sinhvien WHERE MaSV LIKE :keyword OR HoTen LIKE :keyword";

        // Chuẩn bị câu lệnh SQL và thực hiện truy vấn
        $stmt = $this->conn->prepare($query);

        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword); 
        
        $stmt->execute();

        // Kiểm tra xem có kết quả tìm kiếm không
        if ($stmt->rowCount() > 0) {
            // Lấy tất cả các bản ghi tìm thấy
            $students = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $student_item = array(
                    'MaSV' => $row['MaSV'],
                    'HoTen' => $row['HoTen'],
                    'NgaySinh' => $row['NgaySinh'],
                    'GioiTinh' => $row['GioiTinh'],
                    'DiaChi' => $row['DiaChi'],
                    'SDT' => $row['SDT'],
                    'Mail' => $row['Mail'],
                    'MaPhong' => $row['MaPhong'],
                    'TenKhu' => $row['TenKhu'],
                    'user_account' => $row['user_account']
                );
                // Thêm tài khoản vào mảng kết quả
                array_push($students, $student_item);
            }
            return $students;
        } else {
            // Trả về thông báo nếu không tìm thấy kết quả
            return array('message' => 'No records found for keyword: ' . $keyword);
        }
    }
}
