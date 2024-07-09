<?php
class Bill
{
    private $conn;
    public $MaHD;
    public $MaPhong;
    public $Thang;
    public $TienDien;
    public $TienNuoc;
    public $TienMang;
    public $TinhTrang;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    //read data
    public function read()
    {
        $query = "SELECT * FROM hoadon ORDER BY MaHD ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //read data by MaPhong
    public function readByMaPhong($MaPhong)
    {
        // Xây dựng truy vấn SQL để lấy hóa đơn của một phòng cụ thể
        $query = "SELECT * FROM hoadon WHERE MaPhong = ?";

        // Chuẩn bị truy vấn
        $stmt = $this->conn->prepare($query);

        // Gán giá trị cho tham số MaPhong trong truy vấn
        $stmt->bindParam(1, $MaPhong);

        // Thực thi truy vấn
        $stmt->execute();

        // Trả về kết quả truy vấn
        return $stmt;
    }

    //update status
    public function updateStatus()
    {
        $query = "UPDATE hoadon SET TinhTrang = :TinhTrang WHERE MaHD = :MaHD";
        $stmt = $this->conn->prepare($query);

        // Bind dữ liệu
        $stmt->bindParam(':MaHD', $this->MaHD);
        $stmt->bindParam(':TinhTrang', $this->TinhTrang);

        // Thực thi truy vấn
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    //show data
    public function show()
    {
        $query = "SELECT * FROM hoadon WHERE MaHD = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaHD);
        $stmt->execute();

        // Kiểm tra xem có bản ghi nào được trả về không
        if ($stmt->rowCount() > 0) {
            // Nếu có bản ghi, lấy thông tin và gán vào các thuộc tính
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->MaPhong = $row['MaPhong'];
            $this->Thang = $row['Thang'];
            $this->TienDien = $row['TienDien'];
            $this->TienNuoc = $row['TienNuoc'];
            $this->TienMang = $row['TienMang'];
            $this->TinhTrang = $row['TinhTrang'];
        } else {
            // Nếu không có bản ghi nào được tìm thấy, trả về một thông báo lỗi
            return array('message' => 'No record found for ID: ' . $this->MaHD);
        }
    }

    //create data
    public function create()
    {
        $query = "INSERT INTO hoadon SET MaPhong=:MaPhong,Thang=:Thang,TienDien=:TienDien, TienNuoc=:TienNuoc, TienMang=:TienMang, TinhTrang=:TinhTrang";

        $stmt = $this->conn->prepare($query);
        //clearn data
        $this->MaPhong = htmlspecialchars(strip_tags($this->MaPhong));
        $this->Thang = htmlspecialchars(strip_tags($this->Thang));
        $this->TienDien = htmlspecialchars(strip_tags($this->TienDien));
        $this->TienNuoc = htmlspecialchars(strip_tags($this->TienNuoc));
        $this->TienMang = htmlspecialchars(strip_tags($this->TienMang));
        $this->TinhTrang = htmlspecialchars(strip_tags($this->TinhTrang));

        //ket hop 
        $stmt->bindParam(':MaPhong', $this->MaPhong);
        $stmt->bindParam(':Thang', $this->Thang);
        $stmt->bindParam(':TienDien', $this->TienDien);
        $stmt->bindParam(':TienNuoc', $this->TienNuoc);
        $stmt->bindParam(':TienMang', $this->TienMang);
        $stmt->bindParam(':TinhTrang', $this->TinhTrang);


        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }


    //delete data
    public function delete()
    {
        $query = "DELETE FROM hoadon WHERE MaHD=:MaHD";

        $stmt = $this->conn->prepare($query);

        $this->MaHD = htmlspecialchars(strip_tags($this->MaHD));
        $stmt->bindParam(':MaHD', $this->MaHD);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s.\n", $stmt->error);
        return false;
    }
}
